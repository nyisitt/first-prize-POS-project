@extends('master')
@section('contant')
{{--------------- Posts start -----------------}}
<div class="postcontainer " style="background: rgb(54, 50, 50)">
    @if ($posts->count() > 0)
    <h3 class="text-center text-white">NS New Feeds</h3>
    <div class="row mt-5">
        @foreach ($posts as $post)
        <div class="col-6 offset-3 bg-white text-dark p-3 rounded pt-2 mb-3">
         <div class="d-flex justify-content-between">
             <div class="d-flex">
                 <img src="{{asset('images/default male.avif')}}" width="50px" height="50px" class="rounded-circle">
                 <div class="mt-2 ">
                     <h6 class="mb-0">Admin</h6>
                     <p class="text-muted mb-0">{{$post->created_at->diffForHumans()}}</p>
                 </div>
             </div>

         </div>

         <p>{!!$post->post_text!!}</p>

         @if ($post->post_images !== '')
         <div class="row mt-3">
                 @foreach ($images as $image)

                 @if($post->post_images == $image->post_code)
                 <div class=" col-6 mb-3">
                     <img src="{{asset('storage/'.$image->images)}}" width="100%" height="200px" class="rounded">
                 </div>
                 @endif
                 @endforeach
             </div>
         @endif

         <hr>
         <div class="row">
             <input type="hidden"  id="postId" value="{{$post->id}}">
             <div class="col-6  d-flex justify-content-center">
                 <i class="fa-regular fa-thumbs-up " style="cursor: pointer"></i>
                     <p class="ms-3 like" >{{$post->reaction}}</p>
             </div>
             <div class="col-6  d-flex justify-content-center">
                 <i class="fa-regular fa-thumbs-down" style="cursor: pointer"></i>
                 <p class="ms-3 unlike">{{$post->unlike}}</p>
             </div>
         </div>
     </div>
        @endforeach

     </div>
    @else
        <h3 class="text-center p-3 text-white mt-5">There is no Posts yet.</h3>
    @endif

</div>
{{---------------- Posts end -----------------------}}
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('.fa-thumbs-up').click(function(){
            if ($('.fa-thumbs-down').hasClass('clicked')) {
            return;
        }
            if($(this).hasClass('text-warning')){
                $status = 'warning'
            }else{
                $status ='none'
            }
                    $id= $(this).closest('.row').find('#postId').val();
                    var clickedElement = $(this);
                $.ajax({
                    url : '/post/like',
                    type : 'get',
                    data : {'id': $id,'status': $status},
                    dataType : 'JSON',
                    success : function(response){
                    clickedElement.closest('.row').find('.like').html(response.like)
                    if(response.status == 'warning'){
                        clickedElement.removeClass('text-warning')
                        clickedElement.removeClass('clicked')
                    }else{
                        clickedElement.addClass('text-warning')
                        clickedElement.addClass('clicked')
                    }

                    }
                })
        })

        $('.fa-thumbs-down').click(function(){
            if ($('.fa-thumbs-up').hasClass('clicked')) {
            return;
        }
            if($(this).hasClass('text-warning')){
                $status = 'warning'
            }else{
                $status ='none'
            }
                    $id= $(this).closest('.row').find('#postId').val();
                    var clickedElement = $(this);
                $.ajax({
                    url : '/post/unlike',
                    type : 'get',
                    data : {'id': $id,'status': $status},
                    dataType : 'JSON',
                    success : function(response){
                    clickedElement.closest('.row').find('.unlike').html(response.unlike)
                    if(response.status == 'warning'){
                        clickedElement.removeClass('text-warning')
                        clickedElement.removeClass('clicked')
                    }else{
                        clickedElement.addClass('text-warning')
                        clickedElement.addClass('clicked')
                    }

                    }
                })
        })
    })
</script>
@endsection
