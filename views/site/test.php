<div class="container-fluid">
				<header>
					<div class="row">
						<div class="col-lg-3 col-sm-4"><h1>Cocktails</h1></div>
						<div class="col-lg-5 col-sm-4">
							<ul class="nav">
								<li><a href="#" class="btn search">Search</a></li>
								<li><a href="#" class="btn add">Add New</a></li>
							</ul>            
						</div>
						<div class="col-sm-4 text-right">
							<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
								<li class="nav-item">
									<a class="nav-link" href="#"><img src="assets/images/profile-icon.jpg" alt="" class="profile-icon"> George Martin </a>
								</li>                    
							</ul>
						</div>
					</div>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">List</a></li>
						</ol>
					</nav>

					<div class="search-box" id="search-box">    
						<div class="form-row">
							<div class="form-group col-sm-3">
								<input type="text" class="form-control" placeholder="Cocktail Name" id="">
							</div>
							<div class="form-group col-md-3">
								<select id="brand" class="form-control">
									<option selected>Brand Name</option>
									<option>Brand 1</option>
									<option>Brand 2</option>
								</select>
							</div>
							<div class="form-group col-md-3">
								<select id="occasions" class="form-control">
									<option selected>Occasions Name</option>
									<option>Occasions 1</option>
									<option>Occasions 2</option>
								</select>
							</div>
							<div class="form-group col-md-3">
								<button type="submit" class="btn btn-danger">Submit</button>
							</div>    
						</div>        
					</div>  
				</header>

				<div class="contents">
					<div class="table-responsive">
						<table class="table display" id="DataTable">
							<thead>
								<tr>
									<th>Cocktail name</th>
									<th>Brand</th>
									<th>Status</th>
									<th>Last edited (EST)</th>
									<th>View</th>            
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="#">Tanqueray London Dry Jin & Juice</a></td>
									<td>Tanqueray</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch" name="switch">
											<label class="custom-control-label" for="switch">Inactive</label>
										</div>
									</td>
									<td>12-24-2019 18:30 <br>John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
								<tr>
									<td><a href="#">Tanqueray London Dry Jin & Tonic</a></td>
									<td>Tanqueray</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch0" name="switch">
											<label class="custom-control-label" for="switch0">Inactive</label>
										</div>
									</td>
									<td>12-24-2019 18:30 <br>John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
								<tr>
									<td><a href="#">Crown Royal Black Whisky On The Rocks</a></td>
									<td>Crown Royal</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch1" name="switch">
											<label class="custom-control-label" for="switch1">Inactive</label>
										</div>
									</td>
									<td>12-24-2019 18:30 <br>John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
								<tr>
									<td><a href="#">Crown Royal Black Whisky and Cola</a></td>
									<td>Crown Royal</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch2" name="switch">
											<label class="custom-control-label" for="switch2">Inactive</label>
										</div>
									</td>
									<td>12-24-2019 18:30 <br>John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
								<tr>
									<td><a href="#">Smimoff No. 21 Red Vodka Bloody Mary</a></td>
									<td>Smimoff</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch3" name="switch">
											<label class="custom-control-label" for="switch3">Inactive</label>
										</div>
									</td>
									<td>12-24-2019 18:30 <br>John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
								<tr>
									<td><a href="#">Smimoff No. 21 Red Vodka Martini</a></td>
									<td>Smimoff</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch4" name="switch">
											<label class="custom-control-label" for="switch4">Inactive</label>
										</div>
									</td>
									<td>12-24-2019 18:30 <br>John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
								<tr>
									<td><a href="#">Smimoff No. 21 Red Vodka Moscow Mule</a></td>
									<td>Smimoff</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch5" name="switch">
											<label class="custom-control-label" for="switch5">Inactive</label>
										</div>
									</td>
									<td>12-24-2019 18:30 <br>John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
								<tr>
									<td><a href="#">Smimoff No. 21 Red Vodka Bloody Mary</a></td>
									<td>Smimoff</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch6" name="switch">
											<label class="custom-control-label" for="switch6">Active</label>
										</div>
									</td>
									<td>12-24-2019 18:30 <br>John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
								<tr>
									<td><a href="#">Smimoff No. 21 Red Vodka Martini</a></td>
									<td>Smimoff</td>
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="switch7" name="switch">
											<label class="custom-control-label" for="switch7">Inactive</label>
										</div>
									</td>
									<td>12-24-2019 18:30 John Doe</td>
									<td><a href="#" class="icon icon-view"></a></td>
								</tr>
							</tbody>
						</table>
					</div>        
				</div>
				<div class="text-center">
					<div class="dvloader" id="dvloader">Load more</div>
				</div>
			</div>