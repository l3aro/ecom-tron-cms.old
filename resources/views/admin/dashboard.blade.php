@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content')
    <div id="content">
	<div class="home">
		<h1>WELCOME!</h1>
		<ul class="breadcrumb">
		  <li class="active">Home</li>
		</ul>
		<table class="table table-bordered table-striped table-hover">
			<tbody>
				<tr>
					<td>Tổng số bài viết</td>
					<td style="text-align: right"><?php echo number_format( $totalArticles )?></td>
				</tr>
				<tr>
					<td>Tổng số sản phẩm</td>
					<td style="text-align: right"><?php echo number_format( $totalProducts )?></td>
				</tr>
				<tr>
					<td>Số thành viên</td>
					<td style="text-align: right"><?php echo number_format( $totalUsers )?></td>
				</tr>
				<tr>
					<td>Số đơn đặt hàng</td>
					<td style="text-align: right"><?php echo number_format( $totalOrders )?></td>
				</tr>
				<tr>
					<td>Lượt truy cập</td>
					<td style="text-align: right"><?php echo number_format( $counter )?></td>
				</tr>
			</tbody>
		</table>
  <script type="text/javascript">
    $("#menu-dashboard").parent('li').addClass('active');
  </script>
@endsection