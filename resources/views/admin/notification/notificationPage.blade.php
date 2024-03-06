@extends('admin.master')
@section('content')

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


<div class="row ">
    <h2 class="my-3 text-white text-center">Ratings & Reviews Notification</h2>
{{-- Rating and review list start --}}
 <div class=" offset-1 col-4 ">
        @if (!$notification->isEmpty())
        @foreach ($notification as $item)

        <div class="text-end">
            <a href="{{route('admin#ratingSoloDelete',$item->id)}}"><i class="fa-solid fa-trash text-white"></i></a>
        </div>

        <a class=" text-decoration-none notiLink" style="cursor: pointer">
         <input type="hidden" id="notiId" value="{{$item->id}}">
         <div class="card mt-2 mb-3 @if($item->read_at !== null) bg-secondary @endif">
             <div class="card-title d-flex justify-content-between">
                 <h5 class="ms-3 mt-3">{{$item['data']['title']}}</h5>
                 <div class="">{{$item->created_at->diffForHumans()}}</div>
             </div>

             <div class="card-body pt-0 d-flex justify-content-between">
               <p style="line-height: 20px;">{{Illuminate\Support\Str::limit($item['data']['message'], 20)}}</p>
             </div>

             <div class="card-footer" >
                 @php
                 $user =Auth::user()->where('id',$item['data']["sourceable_id"])->select('name','email')->first();
                 $userName = $user->name;
                 $userEmail = $user->email
                 @endphp
                 form {{$userName}} ( {{$userEmail}})
             </div>

           </div>
        </a>
        
         @endforeach
         {{$notification->links()}}
        @else
          <div class="card mt-4">
            <h3 class="text-center text-danger py-5">There is no message</h3>
          </div>
        @endif
    </div>
{{-- Rating and review list end --}}

{{-- Rating and review show start --}}
    <div class=" col-6 " style="margin-left: 50px">
        @if (!$notification->isEmpty())
        <form action="{{route('admin#notiDelete')}}" class="mt-4" method="POST">
            @csrf
            <button class="btn btn-secondary " type="submit">all read messages delete</button>
        </form>
        @endif
       <div class="mt-4" >
        <div class="card">
            <h5 class="card-title text-center my-3">To Show Detail Notification</h5>
            <div class="card-body  m-auto" >
                <img src="{{asset('images/notifications-outline.svg')}}" height="200px"         width="300px" >
            </div>
            <div class="" id="notidetail">

            </div>
            <div class="my-3 text-center" >
                <button class="btn btn-danger w-25" id="readBtn" >Read</button>
            </div>
        </div>


       </div>

    </div>
{{-- Rating and review list end --}}
</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#readBtn').click(function(){
            $parent = $(this).parents('.card')
          $id =  $parent.find('#ratId').val();

          $.ajax({
                url : '/admin/noti/read',
                type : 'get',
                data : {'id':$id},
                dataType : "JSON",
                success : function(response){
                    location.reload();
                }
            })
        })

        $('.notiLink').on('click',function(event){
            event.preventDefault();
            $input = $(this).find('#notiId')
            $id = $input.val();

            $.ajax({
                url : '/admin/notification/detail',
                type : 'get',
                data : {'id':$id},
                dataType : "JSON",
                success : function(response){
                    console.log(response)

                    $('#notidetail').html(`

                    <input type="hidden" name="" id="ratId" value="${response.id}">
                <div class="text-center">
                    <h3>${response.data.title}</h3>
                    <p class="p-3 text-start" style="text-indent: 30px">${response.data.message}</p>

                    <div class="text-end me-2 pb-2">${formatDate(response.created_at)}</div>
                </div>



                    `)

                }
            })
        })


        function formatDate(dateTimeString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };

                const formattedDate = new Date(dateTimeString).toLocaleString('en-US', options);
                    return formattedDate;
                }
    })
</script>
@endsection


