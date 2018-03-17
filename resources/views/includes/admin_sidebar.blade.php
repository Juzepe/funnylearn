<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<ul class="nav menu">
		<li class="{{ Request::path() == 'admin' ? 'active' : '' }}">
			<a href="{{ url('/admin') }}"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a>
		</li>

	  	@ability('', 'ManageRights')
            <li class="{{ starts_with(Request::path(), 'admin/roles') ? 'active' : '' }}">
				<a href="{{ url('/admin/roles') }}"><svg class="glyph stroked chain"><use xlink:href="#stroked-chain"/></svg> Roles</a>
			</li>
			<li class="{{ starts_with(Request::path(), 'admin/permissions') ? 'active' : '' }}">
				<a href="{{ url('/admin/permissions') }}"><svg class="glyph stroked chain"><use xlink:href="#stroked-chain"></use></svg> Permissions</a>
			</li>
        @endability

	  	@ability('', 'ManageUsers')
			<li class="{{ starts_with(Request::path(), 'admin/users') ? 'active' : '' }}">
				<a href="{{ url('/admin/users') }}"><svg class="glyph stroked chain"><use xlink:href="#stroked-chain"></use></svg> Users</a>
			</li>
        @endability

        <li class="{{ starts_with(Request::path(), 'admin/books') ? 'active' : '' }}">
			<a href="{{ url('/admin/books') }}"><svg class="glyph stroked chain"><use xlink:href="#stroked-chain"/></svg> Books</a>
		</li>
	</ul>
</div><!--/.sidebar-->