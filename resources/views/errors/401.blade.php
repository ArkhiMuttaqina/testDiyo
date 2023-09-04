@php
$result = [
                'success' => false,
                'message' => '401 Error',
                'data' => [],
                'queried_at' => date('Y-m-d H:i:s') . ' UTC'
                ];
echo json_encode(response()->json($result, 401));
@endphp
