@include('components.header', ['page_title' => 'تعديل'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل بيانات مستخدم</h4>
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
              <input name="full_name" type="text" class="p-4 form-control" placeholder="الاسم الرباعي" value="{{ $user->full_name }}"/>
            </div>

            <div class="form-group">
              <input name="username" type="text" class="p-4 form-control" placeholder="اسم المستخدم" value="{{ $user->username }}"/>
            </div>

            <div class="form-group">
              <input name="password" type="password" class="p-4 form-control" placeholder="كلمة المرور" value="{{ $user->password }}"/>
            </div>

            <button type="submit" class="btn btn-success py-2 mt-3">
              انشاء
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('users.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')