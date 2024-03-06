@extends('loginRegister.master')
@section('textLogin')
<section class="container forms">
    <div class="rounded p-3" style="background: grey">
        <div class="text-end">
            <a href="{{route('loginPage')}}"> <i class="fa-solid fa-xmark text-dark fa-2x"></i></a>
          </div>
        <div class="form-content" style="width: 500px">
            <h2 class="text-center">OTP Login</h2>
            <form action="{{route('otp#post')}}" method="POST">
                @csrf
                <div class="">
                    <label class="mb-2">Phone Number </label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid
                    @enderror" placeholder="Enter register phone number" oninput="formatPhoneNumber(this)">
                    @error('phone')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class=" float-end">
                    <button class="btn btn-dark rounded my-4 w-100" type="submit">Send </button>
                </div>


            </form>

            </div>
        </div>
</section>
@endsection
@section('loginScript')
<script>
    function formatPhoneNumber(input) {
        // Remove non-numeric characters
        let phoneNumber = input.value.replace(/\D/g, '');

        // Ensure the phone number starts with "09"
        if (!phoneNumber.startsWith('09')) {
            phoneNumber = '09' + phoneNumber;
        }

        // Update the input value
        input.value = phoneNumber;
    }
</script>
@endsection
