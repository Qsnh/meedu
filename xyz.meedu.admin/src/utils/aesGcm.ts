const RAW_KEY = import.meta.env.VITE_AES_KEY as string;

let _cachedKey: CryptoKey | null = null;

async function getKey(): Promise<CryptoKey> {
  if (_cachedKey) return _cachedKey;
  const raw = new TextEncoder().encode(RAW_KEY);
  _cachedKey = await crypto.subtle.importKey('raw', raw, 'AES-GCM', false, ['encrypt']);
  return _cachedKey;
}

export async function encryptPayload(body: object): Promise<string> {
  const key = await getKey();
  const iv = crypto.getRandomValues(new Uint8Array(12));
  const plaintext = new TextEncoder().encode(JSON.stringify(body));
  // Web Crypto API AES-GCM output = ciphertext + AuthTag(16B) already concatenated
  const cipherBuf = await crypto.subtle.encrypt({ name: 'AES-GCM', iv }, key, plaintext);
  const combined = new Uint8Array(12 + cipherBuf.byteLength);
  combined.set(iv, 0);
  combined.set(new Uint8Array(cipherBuf), 12);
  let binary = '';
  combined.forEach((b) => { binary += String.fromCharCode(b); });
  return btoa(binary);
}
