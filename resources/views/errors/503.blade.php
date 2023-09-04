@php
$result = [
'success' => false,
'message' => '503 SERVER UNAVAILABLE TO ACCESS',
'data' => [],
'queried_at' => date('Y-m-d H:i:s') . ' UTC'
];
echo json_encode(response()->json($result, 503));
@endphp
