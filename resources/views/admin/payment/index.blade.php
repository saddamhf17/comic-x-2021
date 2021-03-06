@extends('layouts.admin')

@section('title') Pembayaran @endsection
@section('head')
<link rel="stylesheet" href="/admin/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
@section('back_button')
<a href="{{route('admin.index')}}" class="mb-2 d-block"><small><i class="fa fa-arrow-left"></i> Kembali</small></a>
@endsection
@section('content')
<div class="card shadow mb-4">
    
    <!-- Card Body -->
   <div class="card-body ">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="" class="label text-gray-800">Status Bayar :</label>
          <select name="" id="status_bayar" class="form-control">
            <option  value="{{route('admin.payment.index')}}">Semua</option>
            <option @if(\Request::fullUrl() == route('admin.payment.index', ['status'=>'1'])) selected @endif  value="{{route('admin.payment.index')}}?status=1">Lunas</option>
            <option @if(\Request::fullUrl() == route('admin.payment.index', ['status'=>'0'])) selected @endif value="{{route('admin.payment.index')}}?status=0">Pending</option>
            <option @if(\Request::fullUrl() == route('admin.payment.index', ['status'=>'-1'])) selected @endif value="{{route('admin.payment.index')}}?status=-1">Ditolak</option>
          </select>
        </div> 
      </div>
    </div>
    <br>
       <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>No Invoice</th>
                <th>Subtotal</th>
                <th>Kode Unik</th>
                <th>Total</th>
                <th>User</th>
                <th>Approval</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
          @forelse ($models as $i => $item)
          <tr>
            <td>{{$i + 1}}</td>
            <td>{{$item->invoice()}}</td>
            <td>Rp{{number_format($item->subtotal)}}</td>
            <td>{{$item->unique_number}}</td>
            <td>Rp{{number_format($item->total)}}</td>
            <td>{{$item->user ? $item->user->name : '-'}} <br> <small>{{$item->date()}}</small></td>
            <td>@if($item->approved_by != null) {{$item->approve ? $item->approve->name : '-'}} <br> <small>{{$item->approvedTime()}}</small> @else - @endif</td>
            <td>{!!$item->getStatus()!!}</td>
            <td>
                <a href="{{route('admin.payment.edit',$item->uuid)}}" class="btn btn-warning btn-circle btn-sm">
                    <i class="fas fa-pen"></i>
                </a>
            </td>
          </tr>
            @empty
            <tr>
                <td colspan="9">Belum ada data</td>
            </tr>
            @endforelse


  
            </tbody>
        </table>
       </div>
   </div>
  </div>

@endsection

@section('script')
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function openModalOnHash() {
        if(window.location.hash) {
          var hash = window.location.hash.substring(1);
          $('#'+hash).modal('show');
        }
      }

      $(document).ready(function() {
        openModalOnHash()
      });

    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    $('#status_bayar').change(function(){
        window.location = $(this).find('option:selected').val();
      });

    function deleteData(id) {
      swal({
        title: "Yakin ingin menghapus data?",
        text: "Setelah dihapus, Anda tidak akan dapat memulihkan data tersebut",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $(id).unbind('submit').submit()
          
        } else {
          return false;
        }
      });
    }
</script>
@endsection







