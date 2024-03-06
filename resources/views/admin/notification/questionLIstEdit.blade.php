@extends('admin.master')
@section('content')
    <div class="row">
        <form action="{{route('admin#questionListUpdate')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$comment->id}}">
            <div class=" col-6 offset-3" >
                <div class="mt-4" >
                    <div class="card">
                        <div class="ms-3 mt-2" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></div>
                        <h5 class="card-title text-center my-3">To Update Answer for question</h5>
                        <div class="card-body  m-auto" style="width: 300px; height:200px">
                            <img src="{{asset('images/report-analysis-flatline-d79b7.svg')}}" alt="">
                        </div>
                        <div class="card-body">
                            <div  class=" my-3">
                                <div class="">Question -</div>
                                <div class="ms-3" >{{$comment->comment}}</div>
                            </div>
                            <textarea name="reply" id="replyText" class="form-control" placeholder="Please enter reply">{{$comment->reply}}</textarea>
                            @error('reply')
                                <small>{{$message}}</small>
                            @enderror

                           <div class="mt-3 text-center">
                            <button class="btn btn-dark" type="submit">Update</button>
                           </div>
                        </div>
                    </div>
                   </div>
        </div>
        </form>

    </div>
@endsection
