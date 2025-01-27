
@include('components.header', ['page_title' => __('messages.login_form'), 'body_class' => 'bg-gradient-primary'])

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-6 col-sm-12 mx-auto">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                @if($errors->any)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
                <div class="p-4">
                    <div class="profile-img mx-auto" style="width:150px">
                      <img src="{{ asset('asset/images/rome.svg')}}">
                    </div>
                    <div class="text-center my-4">
                       <h4>{{ __('messages.login_form')}}</h4> 
                      <hr>
                    </div>
                    <form class="user" action="{{ route('loginAction') }}" method="POST">
                      @csrf
                        <div class="form-group">
                          <input type="text" class="form-control form-control-user" name="username" placeholder="اسم المستخدم">
                        </div>
                        
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password"  placeholder="كلمة السر">
                            </div>
                        <button type="submit" class="btn btn-primary active btn-user btn-block">
                           تسجيل دخول
                        </button>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>