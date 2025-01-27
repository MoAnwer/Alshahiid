@include('components.header', ['page_title' => 'تعديل بيانات اسرة الشهيد '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
     <div id="content">	  

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل بيانات اسرة الشهيد  {{ $family->martyr->name }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
			<form action="{{ route('families.update', $family->id) }}" method="POST">
			 @csrf
			 @method('PUT')
	    <label>الشريحة</label>
      
		  <div class="form-group">
				<select class="form-select" name="category">
          @foreach(['أرملة و ابناء','أب و أم و أخوان و أخوات','أخوات','مكتفية'] as $category)
            <option value="{{ $category }}">{{ $category }}</option>
          @endforeach
				</select>
		  </div>

      <label>عدد الافراد: </label>
      <div class="form-group">
        <input class="form-control py-4" type="number" name="family_size" value="{{ $family->family_size }}"/>
      </div>


        <button type="submit" class="btn btn-success py-2 mt-3">
          تعديل
        </button>
        <a class="btn btn-info py-2 mt-3" href="{{ route('families.show', $family->id) }}">رجوع</a>

        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')
