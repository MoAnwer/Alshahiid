<ul class="navbar-nav p-0 bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home')  }}">
        <div class="sidebar-brand-icon bg-light p-1" style="border-radius: 50%;">
            <img src="{{ asset('asset/images/logo.jpg')  }}" style="border-radius: 25%;" alt="logo" width="27">
        </div>
        <div class="sidebar-brand-text mx-3">{{ $app_name }}</div>
    </a>
	
	<li class="nav-item mb-0">
        <a class="nav-link pb-2" href="{{ route('martyrs.index') }}">
            <i class="bi bi-people text-info"></i>
            <span>قائمة الشهداء</span>
		</a>
        </a>
    </li>

    <li class="nav-item mb-0">
        <a class="nav-link pb-2" href="{{ route('families.list') }}">
            <i class="bi bi-people text-info"></i>
            <span>قائمة الأسر </span>
        </a>
        </a>
    </li>
    
	
	
	<li class="nav-item mb-2">
        <a class="nav-link pb-2" href="{{ route('injureds.index') }}">
            <i class="bi bi-people text-info"></i>
            <span> قائمة مصابي العمليات</span>
		</a>
        </a>
    </li>

    <li class="nav-item mb-2">
        <a class="nav-link pb-2" href="{{ route('supervisors.index') }}">
            <i class="bi bi-people text-info"></i>
            <span>مشرفي الاسر</span>
		</a>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#orphans"
            aria-expanded="true" aria-controls="orphans">
            <i class="bi bi-person-fill text-danger ml-2"></i>
            <span>الارامل و الايتام</span>
        </a>
        <div id="orphans" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('widows.index') }}">الارامل</a>
                <a class="collapse-item" href="{{ route('orphans.index') }}">الايتام</a>
            </div>
        </div>
    </li>

	<hr class="sidebar-divider">
	
	<div class="sidebar-heading">
		تقاير محور الرعاية
	</div>

    <li class="nav-item mb-0">
       <a class="nav-link pb-2" href="{{ route('reports.gross') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span>الإجمالي العام</span>
		</a>
        </a>
     </li>
	
	<li class="nav-item mb-0">
       <a class="nav-link pb-2" href="{{ route('reports.projects') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span> تقارير المشروعات</span>
		</a>
        </a>
     </li>

    <li class="nav-item mb-0">
       <a class="nav-link pb-2" href="{{ route('reports.projectsWorkStatusReport') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span>تقرير حالة المشاريع الإنتاجية</span>
        </a>
        </a>
     </li>

     
	<li class="nav-item mb-0">
        <a class="nav-link pb-2" href="{{ route('reports.assistances') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span>تقارير المساعدات</span>
		</a>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#medicalTreatment"
            aria-expanded="true" aria-controls="medicalTreatment">
            <i class="bi bi-newspaper ml-2"></i>
            <span>العلاج الطبي</span>
        </a>
        <div id="medicalTreatment" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('reports.medicalTreatment') }}">العلاج الطبي</a>
                <a class="collapse-item" href="{{ route('medicalTreatment.tamiin') }}">التأمين الصحي</a>
            </div>
        </div>
    </li>


     <li class="nav-item mb-0">
       <a class="nav-link pb-2" href="{{ route('reports.martyrs') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span>الشهداء</span>
		</a>
        </a>
     </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#injureds"
            aria-expanded="true" aria-controls="injureds">
            <i class="bi bi-people ml-2"></i>
            <span>مصابي العمليات</span>
        </a>
        <div id="injureds" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('reports.injuredServices') }}">خدمات مصابي العمليات</a>
                <a class="collapse-item" href="{{ route('reports.injureds') }}">نسبة عجز مصابي العمليات</a>
                <a class="collapse-item" href="{{ route('reports.injuredsTamiin') }}">التأمين الصحي الخاص بالمعاقين</a>
            </div>
        </div>
    </li>


     <li class="nav-item mb-0">
       <a class="nav-link pb-2" href="{{ route('reports.bails') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span>الكفالات</span>
		</a>
        </a>
     </li>

     <li class="nav-item mb-0">
       <a class="nav-link pb-2" href="{{ route('marryAssistances.report') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span>الزواج</span>
		</a>
        </a>
     </li>


	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#money"
			aria-expanded="true" aria-controls="money">
			<i class="bi bi-people ml-2"></i>
			<span>الاسر</span>
		</a>
		<div id="money" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="{{ route('reports.familiesCategories') }}">تصنيف الأسر</a>
				<a class="collapse-item" href="{{ route('reports.familyMembersCount') }}">عدد افراد الأسر</a>
				<a class="collapse-item" href="{{ route('reports.familyMembersCountByCategory') }}">عدد افراد الاسر <br>حسب الشرائح المكفولة</a>
				<!-- <a class="collapse-item" href="{{ route('reports.orphanReport') }}">احصائيات الايتام</a> -->
			</div>
		</div>
	</li>

	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#addresses"
			aria-expanded="true" aria-controls="addresses">
			<i class="bi bi-people ml-2"></i>
			<span>السكن</span>
		</a>
		<div id="addresses" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="{{ route('reports.address') }}">السكن</a>
				<a class="collapse-item" href="{{ route('reports.homes') }}">مشاريع السكن</a>
			</div>
		</div>
	</li>

	<li class="nav-item mb-0">
        <a class="nav-link pb-2" href="{{ route('reports.students') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span>احصاء الطلاب</span>
		</a>
        </a>
    </li>

	<li class="nav-item mb-2">
        <a class="nav-link pb-2" href="{{ route('reports.educationServices') }}">
            <i class="bi bi-newspaper ml-2"></i>
            <span>التعليم</span>
		</a>
        </a>
    </li>
    
    <hr class="sidebar-divider mb-1">

    @can('isModerate')
    <li class="nav-item mb-0">
        	<a class="nav-link pb-2" href="{{ route('users.index') }}">
            	<i class="bi bi-people text-light ml-2"></i>
            	<span>ادارة المستخدمين</span>
			</a>
        </a>
    </li>
    <li class="nav-item mb-0">
    	<a class="nav-link pb-2" href="{{ route('settings.index') }}">
        	<i class="bi bi-menu-button-wide text-success ml-2"></i>
        	<span>الاعدادات</span>
	    </a>
    </li>
    @endcan

   
    <button id="customBtnToggle" class="btn btn-primary active m-2">
        اغلاق
    </button>
</ul>

    <script type="text/javascript">
        document.getElementById('customBtnToggle').addEventListener('click', function (e) {
            document.getElementById('accordionSidebar').classList.toggle('toggled');
        })
    </script>

<!-- End of Sidebar -->