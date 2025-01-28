@include('components.header', ['page_title' => 'بيانات اسرة  الشهيد'])

 <div id="wrapper">


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      
      <div class="container-fluid mt-4">
        <h4>حذف مشروع {{  $project->project_name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
        <x-alert />
        <form action="{{ route('projects.destroy', $project->id ) }}" method="POST">
          <h5>هل تريد حذف مشروع '{{  $project->project_name }}' حقاً ؟</h5>
          @csrf
          @method('DELETE')
            <button type="submit" class="btn btn-danger py-2 mt-3">
              حذف
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('families.socialServices', $project->family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')