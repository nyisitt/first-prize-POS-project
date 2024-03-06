@extends('master')
@section('contant')
<div class="">hello</div>
<section class="notification container">
    
{{-- alert box start --}}
@if(session('message'))
<div class="position-fixed top-20 end-0 p-3" style="z-index: 11">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img src="{{asset('images/2090259-removebg-preview.png')}}" class="" width="50px">
        <strong class="me-auto">NS Shop Website</strong>
        <small>Just Now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body ">
       {{session('message')}}  &#127881; &#127881;
      </div>
    </div>
  </div>
@endif
{{-- alert box end --}}

{{-- Comment Notification start --}}
    @if (count($notification) !== 0)
    <div class="row  ">
        <h3 class="text-center mb-3"> Comment Notification</h3>
        <div class="col-5 notilist">
            @foreach ($notification as $item)
            <div class="card my-3 mx-3 @if ($item->read_at !== null) bg-secondary  @endif " style="cursor: pointer" >
                <a href="{{route('user#soloDelete',$item->id)}}" class="text-end me-2 text-dark"><i class="fa-solid fa-trash"></i></a>
                <a class="text-dark link" >
                    <input type="hidden" value="{{$item->id}}" id="notiId">
                    <div class="card-title">
                        <h5 class="ms-3 mt-1"> {{$item['data']['title']}}</h5>
                     </div>
                     <div class="card-body ">
                         {{Illuminate\Support\Str::limit($item['data']['message'], 10)}}
                     </div>

                     <div class="card-footer d-flex justify-content-between" >
                        <div class="">from {{$item['data']['user_id']}}</div>
                        <div class="">{{$item->created_at->format('M,j,Y')}}</div>
                     </div>

                </a>
               </div>
            @endforeach
               {{$notification->links()}}

        </div>
        <div class="offset-1 col-6">
           <div class="card mt-3 bg-light">
            <div class=" card-title text-center">
                <h4 class="my-3">To Show Notifications</h4>
                <div class="">
                    <img src="{{asset('images/new-message-outline.svg')}}" height="300px">
                </div>
                <div id="showDetail">

                </div>
                <button class="btn btn-danger text-center w-25 read" >read</button>
            </div>
           </div>
        </div>
    </div>
{{-- Comment Notification start --}}
    @else
        <div class="text-center p-5">
            <h3 class="bg-danger d-inline p-3 rounded text-white">There is no notifications</h3>
        </div>
    @endif

</section>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('.read').click(function(){
            $parent = $(this).parents('.card')
          $id =  $parent.find('#Id').val();

          $.ajax({
                url : '/user/noti/read',
                type : 'get',
                data : {'id':$id},
                dataType : "JSON",
                success : function(response){
                    location.reload();
                }
            })

        })
        $('.link').on('click',function(event){
            event.preventDefault();
            $id = $(this).find('#notiId').val();

            $.ajax({
                url : '/user/noti/detail',
                type : 'get',
                data : {'id':$id},
                dataType : "JSON",
                success : function(response){
                    $notiDetail = response.notiDetail;
                    $('#showDetail').html(`
                    <h3>${$notiDetail.data.title}</h3>
                    <input type="hidden" value="${$notiDetail.id}" id='Id'>
                    <div class="mt-2 text-start ms-3">
                        <h5>Question</h5>
                        <p style="text-indent: 20px">${response.question}</p>
                    </div>
                    <div class="mt-2 text-start ms-3">
                        <h5>Answer</h5>
                        <p style="text-indent: 20px">${$notiDetail.data.message}</p>
                    </div>
                    <div class="my-3">
                        <img src="{{asset('storage/${response.productImage}')}}" width="200px" height='200px'>
                    </div>

                    `)

                }
            })
    })
})
</script>

@endsection
