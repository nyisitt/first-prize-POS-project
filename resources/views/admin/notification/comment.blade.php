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
    <h2 class="my-3 text-white text-center">Comment Notifications</h2>
{{-- Comment lists start--}}
    <div class=" offset-1 col-4 ">
        @if (!$notification->isEmpty())
        @foreach ($notification as $item)
        <div class="text-end">
            <a href="{{route('admin#notireadDelete',$item->id)}}" ><i class="fa-solid fa-trash text-white"></i></a>
        </div>

        <div class="notiLink">
        <a class="text-dark text-decoration-none " style="cursor: pointer" >
         <input type="hidden" id="notiId" value="{{$item->id}}">
         <div class="card mt-2 mb-4 @if($item->read_at !== null) bg-secondary @endif">



             <div class="card-title d-flex justify-content-between">
                 <h5 class="ms-3 mt-3">{{$item['data']['title']}}</h5>
                 <div class="">{{$item->created_at->diffForHumans()}}</div>
             </div>

             <div class="card-body pt-0 d-flex justify-content-between">
               <p style="line-height: 20px;">{{Illuminate\Support\Str::limit($item['data']['message'], 20)}}</p>

             </div>

             <div class="card-footer">
                 @php
                 $user =Auth::user()->where('id',$item['data']['user_id'])->select('name','email')->first();
                 $userName = $user->name;
                 $userEmail = $user->email
                 @endphp
                 form {{$userName}} ( {{$userEmail}})

             </div>
           </div>
        </a>
    </div>
         @endforeach
        {{$notification->links()}}
        @else
          <div class="card mt-4">
            <h3 class="text-center text-danger py-5">There is no message</h3>
          </div>
        @endif
    </div>
{{-- Comment lists end--}}

{{-- Comment shows start --}}
    <div class=" col-6 " style="margin-left: 50px">
            <div class="mt-4" >
                <div class="card">
                    <h5 class="card-title text-center my-3">To Answer for Questions</h5>
                    <div class="card-body  m-auto" style="width: 300px; height:200px">
                        <img src="{{asset('images/report-analysis-flatline-d79b7.svg')}}" alt="">
                    </div>
                    <div class="card-body">
                        <div  class=" my-3">
                            <div class="">Question -</div>
                            <div class="ms-3" id="toComment"></div>
                        </div>
                        <textarea name="reply" id="replyText" class="form-control" placeholder="Please enter reply"></textarea>

                        <small class="mt-1 text-danger d-none" id="error">Please fill reply textbox  or something wrong !</small>
                       <div class="mt-3 text-center">
                        <button class="btn btn-dark  " id="reply">Reply</button>
                       </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    @if (!$notification->isEmpty())
                        <a href="{{route('admin#readquesDelete')}}"><button class="btn btn-secondary mt-3" type="submit">all read messages delete</button></a>
                    @endif
                    @if (!$notification->isEmpty())
                    <a href="{{route('admin#questionLists')}}"> <button class="btn btn-secondary mt-3">comment Lists</button></a>
                    @endif
                </div>

               </div>



    </div>
{{-- Comment show end --}}

</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
// Show comment
        $('.notiLink').on('click',function(event){
            event.preventDefault();
            $id= $(this).find('#notiId').val();
            console.log($id);
            $.ajax({
                url : '/admin/noti/question/detail',
                type : 'get',
                data : {'id':$id},
                dataType : "JSON",
                success : function(response){
                    // console.log(response)
                    if(response.message){
                        alert(response.message)
                    }else{
                        if(response.reply !== null){
                        $('#replyText').val(response.reply)
                    }else{
                        $('#replyText').val('');
                    }
                    $('#toComment').html(`
                    <input type="hidden" id="responseNotiId" value="${response.notidetail.id}">
                    <input type="hidden" id="commentId" value="${response.notidetail.data.comment_id}">
                    ${response.notidetail.data.message}
                    `)
                    }

                }

            })
        })
// Reply to comment
        $('#reply').click(function(){
          $reply =  $('#replyText').val();
          $commentId = $('#commentId').val();

          if($reply == '' || $commentId == undefined){
            $('#replyText').addClass('is-invalid')
            $('#error').removeClass('d-none')
          }else{
            $('#replyText').removeClass('is-invalid')
            $('#error').addClass('d-none')
            $data = {
                'status' : '1',
                'notiId' : $('#responseNotiId').val(),
                'commentId' : $('#commentId').val(),
                'reply'  : $('#replyText').val()
            }

            $.ajax({
                url : '/admin/noti/reply',
                type : 'get',
                data : $data,
                dataType : 'JSON',
                success : function(response){
                    alert(response.message)
                    location.reload()
                }
            })

          }
        })

    })
</script>
@endsection
