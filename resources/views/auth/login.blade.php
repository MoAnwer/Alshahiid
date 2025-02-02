
@include('components.header', ['page_title' => __('messages.login_form'), 'body_class' => 'bg-gradient-primary'])

<style>
    .bg-gradient-primary {
        background-color: #7b60ad;
        background-image: linear-gradient(80deg, #7b60ad 100%, #7b60ad 23%);
        background-size: cover;
    }
</style>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-6 col-sm-12 mx-auto">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
              <div class="p-4">
                  @if($errors->any)
                      @foreach($errors->all() as $error)
                          <div class="alert alert-danger">{{$error}}</div>
                      @endforeach
                  @endif
                    <div class="profile-img mx-auto d-flex align-items-center justify-content-center" style="width:150px">
                      <img src="{{ asset('asset/images/logo.jpg')}}" class="mx-auto" style="width:210px">
                    </div>
                    <div class="text-center my-4">
                       <h3>منظمة الشهيد</h3> 
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