@include('components.header', ['page_title' => 'إضافة شهيد'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
	  

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>{{ __('martyrs.new_martyr') }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
			<form action="{{ route('martyrs.store') }}" method="POST">
			 @csrf
			 
			<div class="row">

				<div class="col-3">
					<label>{{ __('martyrs.name') }}</label>
					<div class="form-group">
						<input name="name" type="text" class="form-control py-4" value="{{ old('name') }}" />
			  	</div>	
				</div>

			 <div class="col-3">
			    <label>الرتبة</label>
				  <div class="form-group">
					<select class="form-select" name="rank">
					@foreach(['جندي','جندي أول','عريف','وكيل عريف','رقيب','رقيب أول','مساعد','مساعد أول','ملازم','ملازم أول','نقيب','رائد','مقدم','عقيد','عميد','لواء','فريق','فريق أول','مشير'] as $rank)
						<option value="{{ $rank }}">{{ $rank }}</option>
					@endforeach
					</select>
				  </div>
			  </div>
			  
			<div class="col-3">
			   <label>القوة</label>
			      <div class="form-group">
					<select class="form-select" name="force">
					@foreach(['جهاز الأمن','شرطة موحدة','قوات مسلحة','قرارات','شهداء الكرامة'] as $force)
						<option value="{{ $force }}">{{ $force }}</option>
					@endforeach
					</select>
				  </div>
			 </div>

			 <div class="col-3">
			  <label>الوحدة</label>
					<div class="form-group">
						<input name="unit" type="text" class="form-control py-4" value="{{ old('unit') }}" />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-3">
			  <label>الحالة الاجتماعية</label>
				<div class="form-group">
					<select class="form-select" name="marital_status">
					@foreach(['أعزب','متزوج','مطلق','منفصل'] as $maritalStatus)
						<option value="{{ $maritalStatus }}">{{ $maritalStatus }}</option>
					@endforeach
					</select>
				</div>
			</div>		
			  <div class="col-3">
				<label>النمرة العسكرية</label>
				<div class="form-group">
					<input name="militarism_number" type="number" class="form-control py-4" value="{{ old('militarism_number') }}"/>
				</div>
				
			  </div>
			  
			  <div class="col-3">
			  <label>رقم السجل</label>
				<div class="form-group">
					<input name="record_number" type="number" class="form-control py-4" value="{{ old('record_number') }}" />
				</div>
			  </div>
			  
			  <div class="col-3">
				 <label>تاريخ السجل</label>
					<div class="form-group">
						<input name="record_date" type="date" class="form-control py-4" value="{{ old('record_date') }}" />
					</div> 
			  </div> 
			  
			</div> 
			  
			  <div class="row">
			  	<div class="col-lg-6">
			  		<label>تاريخ الاستشهاد</label>
			  		<div class="form-group">
							<input name="martyrdom_date" type="date" class="form-control py-4" value="{{ old('martyrdom_date') }}" />
			  		</div>				  
			  	</div>
			  	<div class="col-lg-6">
			  		<label>{{ __('martyrs.martyrdom_place')}}</label>
			  		<div class="form-group">
							<input name="martyrdom_place" class="form-control py-4" type="text" value="{{ old('martyrdom_place') }}" />
		  			</div>
		  		</div>
			  </div>

			  <label>الحقوق</label>
			  <div class="form-group">
					<input name="rights" class="form-control py-4" type="number" value="{{ old('rights') }}" />
		  	</div>

        <button type="submit" class="btn btn-success py-2 mt-3">
          انشاء
        </button>
        <a class="btn btn-info py-2 mt-3" href="{{ route('martyrs.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')
