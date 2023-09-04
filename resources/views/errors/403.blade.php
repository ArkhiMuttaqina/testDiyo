
@php
$result = [
'success' => false,
'message' => '403 Forbidden Method',
'data' => [],
'queried_at' => date('Y-m-d H:i:s') . ' UTC'
];
echo json_encode(response()->json($result, 403));
@endphp
