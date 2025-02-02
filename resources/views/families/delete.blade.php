@include('components.header', ['page_title' => 'حذف بيانات اسرة شهيد'])

    <div class="mx-auto p-4 d-flex align-items-center flex-column mt-5 card w-50">

          <div class="card-header">
            <h3> حذف بيانات اسرة الشهيد {{  $family->martyr->name }} </h3>
            <hr class="sidebar-divider" />
          </div>

          <form action="{{ route('families.destroy', $family->id ) }}" method="POST">
          <h5 class="text-center"> حذف بيانات اسرة الشهيد {{  $family->martyr->name }} </h5>
          <p>هل تريد الحذف حقاً ؟,هذا الاجراء سوف يقوم بحذف كل البيانات و الخدمات و المساعدات الخاصة بالاسرة المحددة</p>
          @csrf
          @method('DELETE')
            <div class="d-flex gap-1">
              <button type="submit" class="btn btn-danger py-2 mt-3 w-50">
                <i class="fas fa-trash ml-2"></i>
                حذف
              </button>

              <a class="btn btn-info py-2 mt-3 w-50" href="{{ route('families.show',  $family->id) }}">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
              </a>
            </div>
        </form>

      </div>

  @include('components.footer')