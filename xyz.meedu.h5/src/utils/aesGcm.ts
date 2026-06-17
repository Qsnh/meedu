const encoder = new TextEncoder();
const RAW_KEY = import.meta.env.VITE_AES_KEY as string;

let _keyPromise: Promise<CryptoKey> | null = null;

async function getKey(): Promise<CryptoKey> {
  if (!_keyPromise) {
    _keyPromise = crypto.subtle.importKey('raw', encoder.encode(RAW_KEY), 'AES-GCM', false, ['encrypt'])
      .catch(err => { _keyPromise = null; throw err; });
  }
  return _keyPromise;
}

export async function encryptPayload(body: object): Promise<string> {
  const key = await getKey();
  const iv = crypto.getRandomValues(new Uint8Array(12));
  const cipherBytes = new Uint8Array(await crypto.subtle.encrypt({ name: 'AES-GCM', iv }, key, encoder.encode(JSON.stringify(body))));
  const combined = new Uint8Array(12 + cipherBytes.byteLength);
  combined.set(iv);
  combined.set(cipherBytes, 12);
  return btoa(Array.from(combined, b => String.fromCharCode(b)).join(''));
}
