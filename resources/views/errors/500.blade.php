@php
$result = [
'success' => false,
'message' => '500 Server Error',
'data' => [],
'queried_at' => date('Y-m-d H:i:s') . ' UTC'
];
echo json_encode(response()->json($result, 500));
@endphp
