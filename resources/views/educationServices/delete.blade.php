@include('components.header', ['page_title' => 'حذف بيانات  خدمة تعليمية'])

    <div class="mx-auto p-4 d-flex align-items-center flex-column mt-5 card w-50">

          <div class="card-header">
            <h3>حذف بيانات  خدمة تعليمية - {{  $service->student->familyMember->name }} </h3>
            <hr class="sidebar-divider" />
          </div>

          <form action="{{ route('educationServices.destroy', $service->id ) }}" method="POST">
          <h5>حذف بيانات   {{  $service->type }} </h5>
          @csrf
          @method('DELETE')
            <div class="d-flex gap-1">
              <button type="submit" class="btn btn-danger py-2 mt-3 w-50">
                <i class="bi bi-trash-fill-fill ml-2"></i>
              حذف
              </button>
              <a class="btn btn-info py-2 mt-3 w-50" href="{{ route('students.show',  $service->student->id) }}">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
              </a>
            </div>
        </form>

      </div>

  @include('components.footer')