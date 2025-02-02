@include('components.header', ['page_title' => 'حذف  بيانات التواصل مع اسرة الشهيد ' . $com->family->martyr->name])

    <div class="mx-auto p-4 d-flex align-items-center flex-column mt-5 card w-50">

          <div class="card-header">
            <h3> حذف  بيانات التواصل مع اسرة الشهيد  {{ $com->family->martyr->name }} </h3>
            <hr class="sidebar-divider" />
          </div>

          <form action="{{ route('tazkiia.communicate.destroy', $com->id ) }}" method="POST">
          <h5 class="text-center"> هل تريد حذف  بيانات التواصل مع اسرة الشهيد  <b>{{ $com->family->martyr->name }}</b>  حقاً ؟ </h5>
          @csrf
          @method('DELETE')
            <div class="d-flex gap-1">
              <button type="submit" class="btn btn-danger py-2 mt-3 w-50">
                <i class="fas fa-trash ml-2"></i>
                حذف
              </button>

              <a class="btn btn-info py-2 mt-3 w-50" href="{{ route('tazkiia.communicate.index') }}">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
              </a>
            </div>
        </form>

      </div>

  @include('components.footer')