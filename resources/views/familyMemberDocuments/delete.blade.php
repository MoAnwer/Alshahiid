@include('components.header', ['page_title' => 'حذف وثيقة'])

    <div class="mx-auto p-4 d-flex align-items-center flex-column mt-5 card w-50">

          <div class="card-header">
            <h3> حذف وثيقة  {{  $document->type }} خاصة بـ {{ $document->familyMember->name }} </h3>
            <hr class="sidebar-divider" />
          </div>

          <form action="{{ route('familyMemberDocuments.destroy', $document->id ) }}" method="POST">
          <h5>  هل تريد حذف وثيقة  {{ $document->type }}  حقاً ؟</h5>
          @csrf
          @method('DELETE')
            <div class="d-flex gap-1">
              <button type="submit" class="btn btn-danger py-2 mt-3 w-50">
                <i class="fas fa-trash ml-2"></i>
                حذف
              </button>

              <a class="btn btn-info py-2 mt-3 w-50" href="{{ route('familyMembers.show',  $document->familyMember->id) }}">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
              </a>
            </div>
        </form>

      </div>

  @include('components.footer')