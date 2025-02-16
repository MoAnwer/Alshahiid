@include('components.header', ['page_title' => 'حذف مشروع ' . $project->project_name])

  <div class="mx-auto p-4 d-flex align-items-center flex-column mt-5 card w-50">

    <div class="card-header">
      <h4>حذف مشروع {{  $project->project_name }} </h4>
      <hr class="sidebar-divider" />
    </div>

    <form action="{{ route('projects.destroy', $project->id ) }}" method="POST">
      <h5>هل تريد حذف مشروع '{{  $project->project_name }}' حقاً ؟</h5>
        @csrf
        @method('DELETE')
          <div class="d-flex gap-1">
                <button type="submit" class="btn btn-danger py-2 mt-3 w-50">
                <i class="bi bi-trash-fill-fill ml-2"></i>
              حذف
              </button>
              <a class="btn btn-info py-2 mt-3 w-50" href="{{ route('families.socialServices', $project->family->id) }}">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
              </a>
            </div>
        </form>

      </div>

  @include('components.footer')