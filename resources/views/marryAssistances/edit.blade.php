@include('components.header', ['page_title' =>  'تعديل  خدمة زواج'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h3>تعديل  خدمة زواج {{ $marryAssistance->familyMember->name }}</h3>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
        <x-alert />
        <form action="{{ route('marryAssistances.update', $marryAssistance->id) }}" method="POST">
          @csrf
          @method('PUT')

            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب" @selected($marryAssistance->status == 'مطلوب')>مطلوب</option>
                <option value="منفذ" @selected($marryAssistance->status == 'منفذ')>منفذ</option>
              </select>
            </div>

            <div class="form-group">
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ" value="{{ $marryAssistance->budget }}"/>
            </div>

            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ $marryAssistance->budget_from_org }}"/>
            </div>

            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ $marryAssistance->budget_out_of_org }}"/>
            </div>
            
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ $marryAssistance->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('familyMembers.show', $marryAssistance->familyMember->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')