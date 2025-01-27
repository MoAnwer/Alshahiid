@include('components.header', ['page_title' => 'حذف'])

 <div id="wrapper">


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      
      <div class="container-fluid mt-4">
        <h4>حذف بيانات  {{  $member->name }} </h4>
        <hr />
        
        <form action="{{ route('familyMembers.destroy', $member->id ) }}" method="POST">
          <h4>حذف بيانات  {{  $member->name }} </h4>
          @csrf
          @method('DELETE')
            <button type="submit" class="btn btn-danger py-2 mt-3">
              حذف
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('families.show', $member->family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')