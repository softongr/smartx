$pageId = "583556081518030";
$accessToken = "EAFhROUBDhZAoBPKXWJZCpMAJU4Gzl2JLkTak0l715CXJurBkvwsJN7uGxjUCAlKmzkKrrtmIXy1zCVlGkGaU0AeBr9rTZAusY2GjM1ZBtXLMdqLiFxmP3eMBZCtVEGdKoNFFKZAMZCDiJaSr5oyLSFotytZCXETwJayEaigclNaB8qZBaLvQnZCO0n3aj7RGapZBvK0LCEZAh4sWhqS9kZA4RWZA2rnnIhYyIv4qzLxjlDQlJcAUeZASUxy6q9sGDXOJ9QZD";


/**  $response = Http::withToken($accessToken)
->post("https://graph.facebook.com/v19.0/{$pageId}/feed", [
'message' => "🆕 Νέο προϊόν τώρα διαθέσιμο! ➡️ https://yourdomain.com/product/123",
]); **/
$productUrl = 'https://smartx.gr/kinhta-me-koympia/nokia-105-2019-dual-sim-kinhto-me-koympia-ellhniko-menoy-mayro-6';
$imageUrl = 'https://smartx.gr/20-large_default/nokia-150-2020-gr-dual-sim-kinhto-me-koympia-ellhniko-menoy-mayro-7.jpg'; // 🔁 άλλαξε με σωστό URL εικόνας


$caption = "📱 Nokia 105 (2019) Dual SIM – Κουμπίσια απλότητα, Ελληνικό μενού 🇬🇷\n\nΑπόκτησέ το εδώ ➡️ $productUrl";

$response = Http::withToken($accessToken)
->post("https://graph.facebook.com/v19.0/{$pageId}/photos", [
'url' => $imageUrl,
'caption' => $caption,
]);

dd($response);

if ($response->successful()) {
return response()->json([
'message' => '✅ Επιτυχής ανάρτηση στο Facebook!',
'post_id' => $response->json()['post_id'] ?? 'N/A',
]);
}
