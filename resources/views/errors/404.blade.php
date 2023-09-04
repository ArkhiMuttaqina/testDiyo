
@php
$result = [
'success' => false,
'message' => '404 NOT FOUND',
'data' => [],
'queried_at' => date('Y-m-d H:i:s') . ' UTC'
];
echo json_encode( response()->json($result, 404), true);
@endphp
