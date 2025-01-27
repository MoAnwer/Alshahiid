@include('components.header', ['page_title' => 'حذف'])
    <style type="text/css">
      .content-container {
        position: absolute;
        top: 45%;
        transform: translate(-50%, -50%);
      }
      body {
        height: 100vh;
      }
    </style>

    <div class="mx-auto">
        <div class="w-50 p-4 content-container d-flex align-items-center flex-column card">
          @if(session('error'))
            <div class="alert alert-danger w-100"> {{ session('error') }} </div>
          @endif

          <div class="card-header">
            <h3>حذف بيانات المستخدم  {{  $user->full_name }} </h3>
            <hr class="sidebar-divider" />
          </div>

          <form action="{{ route('users.destroy', $user->id ) }}" method="POST">
          @csrf
          @method('DELETE')
            <div class="form-group">
              <label>الرجاء تأكيد العملية بكتابة كلمة المرور الخاصة بك  {{ auth()->user()->username }}</label>
              <input name="password" type="password" class="p-4 mt-2 form-control" placeholder="كلمة المرور" value="{{ old('password') }}"/>
            </div>

            <div class="d-flex gap-1">
              <button type="submit" class="btn btn-danger py-2 mt-3 w-50">
                <i class="fas fa-trash ml-2"></i>
              حذف
              </button>
              <a class="btn btn-info py-2 mt-3 w-50 d-flex" href="{{ route('users.index') }}">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
              </a>
            </div>
        </form>

      </div>
    </div>
  @include('components.footer')