const RAW_KEY = import.meta.env.VITE_AES_KEY as string;

let _keyPromise: Promise<CryptoKey> | null = null;

async function getKey(): Promise<CryptoKey> {
  if (!_keyPromise) {
    const raw = new TextEncoder().encode(RAW_KEY);
    _keyPromise = crypto.subtle.importKey('raw', raw, 'AES-GCM', false, ['encrypt']);
  }
  return _keyPromise;
}

export async function encryptPayload(body: object): Promise<string> {
  const key = await getKey();
  const iv = crypto.getRandomValues(new Uint8Array(12));
  const plaintext = new TextEncoder().encode(JSON.stringify(body));
  const cipherBytes = new Uint8Array(await crypto.subtle.encrypt({ name: 'AES-GCM', iv }, key, plaintext));
  const combined = new Uint8Array(12 + cipherBytes.byteLength);
  combined.set(iv, 0);
  combined.set(cipherBytes, 12);
  return btoa(String.fromCharCode(...combined));
}
