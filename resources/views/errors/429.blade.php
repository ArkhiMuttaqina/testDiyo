@php
$result = [
'success' => false,
'message' => '429 Too Many Request, Try Again later for 10 Minutes',
'data' => [],
'queried_at' => date('Y-m-d H:i:s') . ' UTC'
];
echo json_encode(response()->json($result, 429));
@endphp
