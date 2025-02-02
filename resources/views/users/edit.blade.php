@include('components.header', ['page_title' => 'تعديل'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل بيانات مستخدم {{ $user->full_name }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('users.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')

            <div class="form-group">
              <label>الاسم الرباعي</label>
              <input name="full_name" type="text" class="p-4 form-control" value="{{ $user->full_name }}"/>
            </div>

            <div class="form-group">
              <label>اسم المستخدم</label>
              <input name="username" type="text" class="p-4 form-control" placeholder="{{ $user->username }}"/>
            </div>

            <div class="form-group">
              <input name="password" type="password" class="p-4 form-control" placeholder="كلمة المرور (دعها فارغة اذا لم ترغب بالتعديل)" value="{{ old('password') }}"/>
            </div>

            <label>الوظيفة</label>
              <div>
                <label>مستخدم عادي</label>
                <input name="role" type="radio" value="user" @checked($user->role == 'user')>
                <label>ادمن</label>
                <input name="role" type="radio" value="admin" @checked($user->role == 'admin')/>
              </div>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('users.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')