@extends('layouts.app')

@section("title","Contact Us")

@section("content")

        <div class="container row bg-dark rounded mx-auto my-5 p-3 contact-body" style="opacity: 0.8;min-height: 650px;">
            <div class="container-fluid text-white col-md-12 col-lg-7 col-xl-6">
                <h4>Address :</h4>
                <h5>B-418, Kutbi Sheri,</h5>
                <h5>Moti Vhorvad,</h5>
                <h5>Kapadwanj - 387620,</h5>
                <h5>Gujarat, India.</h5>

                <h5>Contact :   <p><a class="text-white" href="tel:+919924104072">+91-99241040721</a>  (Mobile Phone , Whatsapp)</p>
                                <p><a class="text-white" href="tel:+918980407187">+91-8980407187</a>  (Mobile Phone)</p>
                </h5>
            </div>
            <div class="container-fluid text-white col-md-12 col-lg-5 col-xl-6">
                @if(session("msg"))
                    <div class="alert alert-success">
                        {{session("msg")}}
                    </div>
                @endif
                    <form method="POST" action="contact">
                        @csrf
                        @method("put")
                        <div class="form-group ">
                            <label for="name" class="col-form-label ">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>

                        <div class="form-group ">
                            <label for="email" class="col-form-label ">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label">Description</label>
                                <textarea rows="5" class="form-control @error('description') is-invalid @enderror" id="description" name="description" autocomplete="description" placeholder="Enter your purpose..." cols="20">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Submit
                                </button>
                        </div>

                </form>
            </div>
        </div>


@endsection
