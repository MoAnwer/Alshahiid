@include('components.header', ['page_title' => 'بيانات اسرة  الشهيد'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <x-alert/>

        <div class="d-flex justify-content-between align-items-center px-3">
          <div>
            <h4>اسرة الشهيد {{ $family->martyr->name }}</h4>
            <span>عدد افراد الاسرة {{ $family->family_size }} , و تم اضافة {{ $family->loadMissing('familyMembers')->familyMembers->count() }} منهم الى النظام</span>
          </div>

          <div>
            <a href="{{ route('families.edit', $family->id) }}" class="btn btn-success p-2 fa-sm">
            <i class="fa fa-edit"></i>
          </a>
          <a href="{{ route('families.delete', $family->id) }}" class="btn btn-danger p-2 fa-sm">
            <i class="fa fa-trash"></i>
          </a>
          </div>

          @if ($family->loadMissing('familyMembers')->familyMembers->count() < $family->family_size)
            <a class="btn btn-primary active" href="{{ route('familyMembers.create', $family) }}">اضافة فرد جديد</a>
          @endif
        </div>

        <x-table>
          <x-slot:head>
            <th>اسم</th>
            <th>النوع</th>
            <th>العمر</th>
            <th>العلاقة</th>
            <th>الصورة الشخصية</th>
            <th>رقم التأمين الصحي</th>
            <th>بداية التأمين الصحي</th>
            <th>نهاية التأمين الصحي</th>
            <th>رقم الهاتف</th>
            <th>الرقم الوطني</th>
            <th>عمليات</th>
          </x-slot:head>

          <x-slot:body>
          @if($family->loadMissing('familyMembers')->familyMembers->count() > 0)
            @foreach($family->loadMissing('familyMembers')->familyMembers as $familyMember)
              <tr>
                <td>{{ $familyMember->name }}</td>
                <td>{{ $familyMember->gender }}</td>
                <td>{{ $familyMember->age }}</td>
                <td>{{ $familyMember->relation }}</td>
                <td>
                  @if(!is_null($familyMember->personal_image))
                  <a href="{{ url("uploads/images/{$familyMember->personal_image}") }}">
                    <img src="{{ url("uploads/images/{$familyMember->personal_image}") }}" width="50"/>
                  </a>
                  @else
                    -
                  @endif
                </td>
                <td>{{ $familyMember->health_insurance_number }}</td>
                <td>{{ $familyMember->health_insurance_start_date }}</td>
                <td>{{ $familyMember->health_insurance_end_date }}</td>
                <td>{{ $familyMember->phone_number }}</td>
                <td>{{ $familyMember->national_number }}</td>
                <td>
                    <a href="{{ route('familyMembers.edit', ['family' => $family->id, 'member' => $familyMember->id]) }}" class="btn btn-success p-2 fa-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('familyMembers.delete', $familyMember->id) }}" class="btn btn-danger p-2 fa-sm">
                      <i class="fa fa-trash"></i>
                    </a>
					          <a href="{{ route('familyMembers.show', $familyMember->id) }}" class="btn btn-info p-2 fa-sm">
                      <i class="fa fa-user"></i>
                    </a>
                  </td>
              </tr>
            @endforeach

            @else
              <tr>
                <td colspan="11"> 
                  لا يوجد افراد
                  <b> [ مطلوب افراد {{ $family->family_size }} ]</b>
                </td>
              </tr>
            @endif
          </x-slot:body>
        </x-table>

      <hr />

      {{-- Supervisor --}}
      <div class="d-flex justify-content-between align-items-center px-3">
        <h4>المشرف على اسرة الشهيد {{ $family->martyr->name }}</h4>
      </div>

      <x-table>
          <x-slot:head>
            <th>اسم المشرف</th>
            <th>رقم الهاتف</th>
            <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
          @isset($family->supervisor)              
              <tr>
                <td>{{ $family->supervisor->name }}</td>
                <td>{{ $family->supervisor->phone }}</td>
                <td>
                  <a href="{{ route('families.editSupervisor', $family->id) }}" class="btn btn-success px-2">
                    <i class="fas fa-edit fa-sm"></i>
                  </a>
                  <a href="{{ route('families.deleteSupervisor', $family->id) }}" class="btn btn-danger px-2">
                    <i class="fas fa-trash fa-sm"></i>
                  </a>
                </td>
              </tr>
            @else
              <tr>
                <td colspan="5">
                  <a href="{{ route('families.createSupervisor', $family->id) }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    إضافة مشرف
                  </a>
                </td>
              </tr>
            @endisset

          </x-slot:body>
        </x-table>

      {{--/ Suprvisor --}}

      <!-- Address -->
      <hr>

      <div class="d-flex justify-content-between align-items-center px-3">
        <h4>مكان سكن الاسرة</h4>
        <a class="btn btn-primary active " href="{{ route('address.create', $family) }}">اضافة مسكن جديد</a>
      </div>
       <x-table>
          <x-slot:head>
            <th>القطاع</th>
            <th>المحلية</th>
            <th>الحي</th>
            <th>نوع المسكن</th>
            <th>عمليات</th>
          </x-slot:head>

          <x-slot:body>
          @isset($family->addresses)
			      @foreach($family->addresses as $address)
              <tr>
               <td>{{ $address->sector }}</td>
               <td>{{ $address->locality }}</td>
               <td>{{ $address->neighborhood}}</td>                
               <td>{{ $address->type }}</td>
               <td>
                  <a href="{{ route('address.edit', $address->id) }}" class="btn btn-success p-2 fa-sm">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="{{ route('address.delete', $address->id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="fa fa-trash"></i>
                  </a>
              </td>
            </tr>
			     @endforeach
            @else
              <tr>
                <td colspan="5">لا يوجد سكن</td>
              </tr>
            @endisset
          </x-slot:body>
        </x-table>

        <hr>

        <!--/ Address  -->

        <!-- Services -->
        <h4>الخدمات الاجتماعية</h4>  
        <hr/>
          
        {{-- Assistances --}}

        <div class="d-flex justify-content-between align-items-center px-3">
          <h5>المساعدات</h5>
          <a class="btn btn-primary active" href="{{ route('assistances.create', $family->id) }}">اضافة مساعدة جديد</a>
        </div>

         <x-table>
            <x-slot:head>
              <th>النوع</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من  داخل المنظمة</th>
              <th>من  خارج المنظمة</th>
			        <th>المبلغ المؤمن</th>
              <th>ملاحظات</th>
              <th>عمليات</th>
            </x-slot:head>

            <x-slot:body>
			      @isset($family->assistances)			
             @foreach($family->assistances as $assistance)
                <tr>
                  <td>{{ $assistance->type }}</td>
                  <td>{{ $assistance->status }}</td>
                  <td>{{ number_format($assistance->budget) }}</td>
                  <td>{{ number_format($assistance->budget_from_org) ?? '-' }}</td>
                  <td>{{ number_format($assistance->budget_out_of_org) ?? '-' }}</td>
				          <td>{{ number_format($assistance->budget_from_org + $assistance->budget_out_of_org) }}</td>
                  <td>{{ $assistance->notes ?? 'لايوجد' }}</td>
                  <td>
                    <a href="{{ route('assistances.edit', ['family' => $family->id, 'id' => $assistance->id])}}" class="btn btn-success p-2 fa-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('assistances.delete', $assistance->id)}}" class="btn btn-danger p-2 fa-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
			       @else
				      <tr>
					       <td colspan="10">لا توجد مساعدات</td>
				      </tr>
			       @endisset
            </x-slot:body>
          </x-table>

        {{-- / Assistances --}}


          <!-- Porjects -->
          <div class="d-flex justify-content-between align-items-center px-3">
            <h5>المشاريع </h5>
            <a class="btn btn-primary active" href="{{ route('projects.create', $family->id) }}">اضافة مشروع جديد</a>
          </div>
          
          <x-table>
            <x-slot:head>
              <th>اسم المشروع</th>
              <th>النوع</th>
              <th>الحالة</th>
              <th>الحالة التشغيلية</th>
              <th>التقديري</th>
              <th>المدير</th>
              <th>من  داخل المنظمة</th>
              <th>من  خارج المنظمة</th>
              <th>المبلغ المؤمن</th>
              <th>ملاحظات</th>
              <th>عمليات</th>
            </x-slot:head>

          <x-slot:body>
			     @if($family->loadMissing('projects')->projects->count() > 0)
             @foreach($family->loadMissing('projects')->projects as $project)
              <tr>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->project_type }}</td>
                <td>{{ $project->status }}</td>
                <td>{{ $project->work_status }}</td>
                <td>{{ number_format($project->budget) }}</td>
                <td>{{ !empty($project->manager_name) ? $project->manager_name : '-' }}</td>
                <td>{{ number_format($project->budget_from_org) ?? '-' }}</td>
                <td>{{ number_format($project->budget_out_of_org ) ?? '-' }}</td>
                <td>{{ number_format($project->budget_from_org + ($project->budget_out_of_org ?? 0)) }}</td>
                <td>{{ $project->notes ?? 'لايوجد' }}</td>
                <td>
                  <a href="{{ route('projects.edit', ['family' => $family->id, 'project' => $project->id]) }}" class="btn btn-success p-2 fa-sm">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="{{ route('projects.delete', $project->id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="fa fa-trash"></i>
                  </a>
                  </td>
                </tr>
              @endforeach
			         @else
			          <tr>
				           <td colspan="10">لا توجد مشاريع</td>
			          </tr>
			       @endif
            </x-slot:body>
          </x-table>
          <hr>

        <!--/ Porjects -->

        <!-- Homes -->
		
  		<div class="d-flex justify-content-between align-items-center px-3">
        <h5>مشاريع السكن</h5>
          <a class="btn btn-primary active" href="{{ route('homes.create', $family->id) }}">اضافة مشروع جديد</a>
        </div>

         <x-table>
            <x-slot:head>
              <th>النوع</th>
              <th>الحالة</th>
			        <th>المدير</th>
              <th>التقديري</th>
              <th>من  داخل المنظمة</th>
              <th>من  خارج المنظمة</th>
			        <th>المبلغ المؤمن</th>
              <th>ملاحظات</th>
              <th>عمليات</th>
            </x-slot:head>

            <x-slot:body>
			       @isset($family->homeService)			
             @foreach($family->homeServices as $homeService)
                <tr>
                  <td>{{ $homeService->type }}</td>
                  <td>{{ $homeService->status }}</td>
				          <td>{{ $homeService->manager_name }}</td>
                  <td>{{ number_format($homeService->budget) }}</td>
                  <td>{{ number_format($homeService->budget_from_org) ?? '-' }}</td>
                  <td>{{ number_format($homeService->budget_out_of_org) ?? '-' }}</td>
				          <td>{{ number_format($homeService->budget_from_org + $homeService->budget_out_of_org) }}</td>
                  <td>{{ $homeService->notes ?? 'لايوجد' }}</td>
                  <td>
                    <a href="{{ route('homes.edit', $homeService->id)}}" class="btn btn-success p-2 fa-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('homes.delete',  ['home' => $homeService->id])}}" class="btn btn-danger p-2 fa-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
			       @else
				      <tr>
					       <td colspan="10">لا توجد مشاريع</td>
				      </tr>
			       @endisset
            </x-slot:body>
          </x-table>
          <hr>
        <!--/ Homes -->

        </div>
      </div>
    </div>

  @include('components.footer')