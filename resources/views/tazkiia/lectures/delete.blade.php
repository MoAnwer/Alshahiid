@include('components.header', ['page_title' => 'حذف  محاضرة ' . $lecture->name])

    <div class="mx-auto p-4 d-flex align-items-center flex-column mt-5 card w-50">

          <div class="card-header">
            <h3> حذف  محاضرة  <b>{{ $lecture->name }}</b> </h3>
            <hr class="sidebar-divider" />
          </div>

          <form action="{{ route('tazkiia.lectures.destroy', $lecture->id ) }}" method="POST">
          <h5 class="text-center"> هل تريد حذف  محاضرة <b>{{ $lecture->name }}</b>  حقاً ؟ </h5>
          @csrf
          @method('DELETE')
            <div class="d-flex gap-1">
              <button type="submit" class="btn btn-danger py-2 mt-3 w-50">
                <i class="fas fa-trash ml-2"></i>
                حذف
              </button>

              <a class="btn btn-info py-2 mt-3 w-50" href="{{ route('tazkiia.lectures.index') }}">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
              </a>
            </div>
        </form>

      </div>

  @include('components.footer')