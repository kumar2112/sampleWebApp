@extends('layouts.app')
@section('content')
<div class="container">
  <div id="alert-message"></div>
  <div class="row">
      <div class="col-md-12 text-right">
          <a href="{{route('router.create')}}">Add Router</a>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
            <thead>
              <tr>
                  <th>#ID</th>
                  <th>DNS Records</th>
                  <th>Host Name</th>
                  <th>Client Ip Address</th>
                  <th>Mac Address</th>

                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($Routers as $router)
               <tr>
                  <td><strong>#{{$router->id}}</strong></td>
                  <td>{{$router->dns_records}}</td>
                  <td>{{$router->internet_host_name}}</td>
                  <td>{{$router->client_ip_address}}</td>
                  <td>{{$router->mac_address}}</td>
                  <td>
                    <a href="{{route('router.edit',array('id'=>rtrim(base64_encode($router->id),'==')))}}"><i class="fa fa-edit">Edit</i></a>
                    <b>| </b>
                    <a class="deleteRouter" href="{{route('router.delete',array('id'=>rtrim(base64_encode($router->id),'==')))}}" ><i class="fa fa-trash">Delete</i></a>
                  </td>
               </tr>
               @endforeach
            </tbody>
        </table>
        {{ $Routers->links() }}
      </div>
  </div>
</div>
<script>
      $(document).ready(function(){
          //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $(".deleteRouter").click(function(){
            var elm=$(this);
              $.ajax({
                  /* the route pointing to the post function */
                  url: $(this).attr('href'),
                  type: 'GET',
                  /* send the csrf-token and the input to the controller */
                  dataType: 'JSON',
                  /* remind that 'data' is the response of the AjaxController */
                  success: function (data) {
                      if(data.status=="success"){
                          elm.closest('tr').remove();
                          $("#alert-message").html('<div class="alert alert-success">'+data.message+'</div>');
                          //form.reset();
                      }else if(data.status=="error"){
                          $("#alert-message").html('<div class="alert alert-danger">'+data.message+'</div>');
                      }
                  }
              });
              return false;
          });
     });
</script>
@stop
