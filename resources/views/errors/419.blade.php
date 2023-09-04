@php
$result = [
'success' => false,
'message' => '419 Page was Expired, Please Relogin.',
'data' => [],
'queried_at' => date('Y-m-d H:i:s') . ' UTC'
];
echo json_encode(response()->json($result, 419));
@endphp
