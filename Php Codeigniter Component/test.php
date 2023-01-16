<div class="content-wrapper" id='app'>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">

    
                    <table-component :submenu="submenu"></table-component>

                    <form-component :sponsorship_category="sponsorship_category" :school_register="school_register"></form-component>

                    <div class="card-header d-flex align-items-center border-0">
                        <h3 class="w-50 float-left card-title m-0">Frontend Sub Menu List</h3>
                        <div class="dropdown dropleft text-right w-50 float-right">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNew">Add Sub Menu</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="" method="post">
                        <div class="card-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th>SL No</th>
                                        <th>Menu Name</th>
                                        <th>Sub Menu Name</th>
                                        <th>Sub Menu Order</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">


                                    <tr v-for="(row,index) in submenus" :key="index" v-if="submenus">
                                        <td>{{index+1}}</td>

                                        <td>
                                            <menuname-component :frontendmenuid="row.frontend_menu_id"></menuname-component>
                                        </td>

                                        <td>{{row.submenu_name}}</td>
                                        <td>{{row.submenu_order}}</td>
                                        <td>{{row.remarks}}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" @click.prevent="editModal(row)">Edit</button>&nbsp;
                                            <button class="btn btn-danger btn-sm" @click.prevent="deleteRow(row)">Delete</button>
                                        </td>
                                    </tr>

                                    <tr v-if="!count">
                                        <td colspan="10" class="text-center">Data Not Found</td>
                                    </tr>

                                </tbody>



                            </table>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>



<script type="text/javascript">

    const app = Vue.createApp({
        data() {
            return {
                submenu_name: '',
                submenu_order: '',
                remarks: '',
                menu_error: '',
                submenu_error: '',
                order_error: '',
                base_url: '<?php echo base_url(); ?>',
                data: new FormData(),
                submenus: [],
                count: 0,
                frontend_menu_id: '',
                frontend_submenu_id: '',
                breadcam: "parent(main) child(breadcam) relation",
                submenu:[
                    <?php 
                        foreach($submenus as $key=>$row){
                            echo '{ frontend_menu_id: "' . $row->frontend_menu_id . '", submenu_name: "' . $row->submenu_name . '" },';
                        }    
                    ?>
                ],
                sponsorship_category:[
                    <?php 
                        foreach($sponsorship_category as $key=>$row){
                        echo '{ sponsorship_category_id: "' . $row->sponsorship_category_id . '", sponsorship_category_name: "' . $row->sponsorship_category_name . '" },';
                        }    
                    ?>
                ],
                school_register:[
                    <?php 
                    foreach($school_register as $key=>$row){
                        echo '{ school_register_id: "' . $row->school_register_id . '", school_name: "'. $row->school_name .'" },';
                    } 
                    ?>
                ],
            }
        },

        mounted() {
            setTimeout(this.showFrontendSubMenu(), 1000);
        },
        methods: {

            async showFrontendSubMenu() {
                await axios.get(this.base_url + 'TestController/showFrontendSubMenu')
                    .then((response) => {
                        if (response.data.result) {
                            this.submenus = response.data.result;
                            this.count = response.data.result.length;
                            //console.log(response.data.result);
                        } else {
                            this.submenus = [];
                            this.count = '';
                        }
                        //console.log(response.data.result)

                    })
                    .catch((error) => {
                        console.log(error);
                    })
            },
        }
    });

    app.component('form-component', {
        props: {
            sponsorship_category: {
                type: Array,
                required: true
            },
            school_register: {
                type: Array,
                required: true
            }
        },

        data(){
            return {
                header: "Search Options",
                bcss_unique_code: '',
                class_id: '',
                sponsorship_category_id: '',
                school_register_id: '',
                area_id: '',
                donar_register_id: '',
                last_name: '',
                sponsor_code: '',
                gender: '',
                sm_status: '',
                report_name: '',
                error: '',
                base_url: "<?php echo base_url(); ?>",
                students: [],
                is_found: false,
                count: 0,
                isVisible: false,
            }
        },

        mounted() {
           //console.log(this.sponsorship_category);
           //console.log(this.school_register);
        },
        methods:{
        handle(){
            this.isVisible = !this.isVisible;
        },
        clearFilterData(){
                location.reload();
        },

        async filterData(){
                await axios
	          .get(this.base_url + "TestController/filter_data?bcss_unique_code=" + this.bcss_unique_code + '&class_id=' + this.class_id + '&sponsorship_category_id=' + this.sponsorship_category_id + '&school_register_id=' + this.school_register_id + '&area_id=' + this.area_id + '&donar_register_id=' + this.donar_register_id + '&last_name=' + this.last_name + '&sponsor_code=' + this.sponsor_code + '&gender=' + this.gender + '&sm_status=' + this.sm_status)
	          .then((response) => {
	            if (response.data.status === 'success') {
	              console.log(response.data.result);
                  this.students = response.data.result;
                  this.count = response.data.result.length;
                  this.is_found = true;
	            } else {
                  this.students = [];
                  this.is_found = false;
                  this.count = 0;
	              console.log('data not found')
                  iziToast.error({
                    title: "Error !",
                    position: "topCenter",
                    message: "Opps! Data not Found.",
                });
	            }
	          })
	          .catch((error) => {
	            console.log(error);
	          });
              history.pushState(null, null, "?bcss_unique_code=" + this.bcss_unique_code + '&class_id=' + this.class_id + '&sponsorship_category_id=' + this.sponsorship_category_id + '&school_register_id=' + this.school_register_id + '&area_id=' + this.area_id + '&donar_register_id=' + this.donar_register_id + '&last_name=' + this.last_name + '&sponsor_code=' + this.sponsor_code + '&gender=' + this.gender + '&sm_status=' + this.sm_status);
	      },
    },
        template:
            /*html*/
            `
            <div class="card">
                            <div class="card-header bg-default">
                            <h4><strong>{{ header }}</strong>&nbsp;&nbsp;<button @click="handle" class="btn btn-default">Click</button></h4>
                            </div>
                            <div class="card-body" v-if="isVisible">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Child Code</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" v-model.trim="bcss_unique_code" placeholder="Child Code">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1"></div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Grade</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" v-model="class_id">
                                                <option value="" selected disabled>Select Any</option>
                                                <?php  $class = $this->db->get('class')->result(); ?>
                                                <?php if(!empty($class)){ ?>
                                                    <?php foreach($class as $row) { ?>
                                                <option value="<?php echo $row->class_id; ?>"><?php echo $row->class_name; ?></option>
                                                <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">S'ship Category</label>
                                            <div class="col-sm-10">
                                                <select v-model="sponsorship_category_id" class="form-control">
                                                <option value="" selected disabled>Select Any</option>
                                                <option v-for="(row,key) in sponsorship_category" :value="row.sponsorship_category_id">{{ row.sponsorship_category_name }}</option>
                                                </select>
                                            </div>
                                           
                                        </div>
                                    </div>

                                    <div class="col-md-1"></div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">School</label>
                                            <div class="col-sm-10">
                                                <select v-model="school_register_id" class="form-control">
                                                <option value="" selected disabled>Select Any</option>
                                                <option v-for="(row,key) in school_register" :value="row.school_register_id">{{ row.school_name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Area</label>
                                            <div class="col-sm-10">
                                            
                                                <select v-model="area_id" class="form-control">
                                                <option value="" selected disabled>Select Any</option>
                                                <?php  $area = $this->db->get('area')->result(); ?>
                                                <?php if(!empty($area)){ ?>
                                                    <?php foreach($area as $row) { ?>
                                                <option value="<?php echo $row->area_id; ?>"><?php echo $row->area_name; ?></option>
                                                <?php } } ?>
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-1"></div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Donar</label>
                                            <div class="col-sm-10">
                                                <select v-model="donar_register_id" class="form-control">
                                                <option value="" selected disabled>Select Any</option>
                                                <?php  $donar_register = $this->db->get('donar_register')->result(); ?>
                                                <?php if(!empty($donar_register)){ ?>
                                                    <?php foreach($donar_register as $row) { ?>
                                                <option value="<?php echo $row->donar_register_id; ?>"><?php echo $row->agency_name; ?></option>
                                                <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                             <input type="text" class="form-control" v-model.trim="last_name" placeholder="Last Name">
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-1"></div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Sponsor Code</label>
                                            <div class="col-sm-10">
                                             <input type="text" class="form-control" v-model.trim="sponsor_code" placeholder="Sponsor Code">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Gender</label>
                                            <div class="col-sm-10">
                                             <select class="form-control" v-model="gender">
                                                <option selected="" disabled="" value="">Select Any one</option>
                                                 <option value="1">Male</option>
                                                 <option value="2">Female</option>
                                             </select>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-1"></div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Sponsor Status</label>
                                            <div class="col-sm-10">
                                             <select class="form-control" v-model="sm_status">
                                                <option selected="" disabled="" value="">Select Any one</option>
                                                 <option value="2">Sponsored</option>
                                             </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <hr>
                                    <button type="button" @click.prevent="filterData" class="btn btn-primary">Search</button>&nbsp;
                                    <button type="button" @click.prevent="clearFilterData" class="btn btn-default">Clear Filter</button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        
        `,
    });

    app.component('table-component', {
        props: {
            submenu: {
                type: Array
            }
        },

        data(){
            return {

            }
        },

        mounted() {
           //console.log(this.submenu);
        },
        template:
            /*html*/
            `
            <div class="card-body table-responsive">
                            <table id="example11" class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th>SL No</th>
                                        <th>Menu Name</th>
                                        <th>Sub Menu Name</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                    <tr v-for="(row,key) in submenu" :key="key">
                                        <td>{{ key + 1}}</td>
                                        <td>{{ row.frontend_menu_id}}</td>
                                        <td>{{ row.submenu_name}}</td>
                                    </tr>
                  

                                    

                                </tbody>



                            </table>
                        </div>
        `,
    });

    

    app.component('menuname-component', {
        props: {
            frontendmenuid: {
                type: String
            }
        },
        mounted() {
            //console.log(this.frontendmenuid);
            this.find_menu();
        },
        data() {
            return {
                breadcamtext: 'This is breadcam',
                base_url: '<?php echo base_url(); ?>',
                menu: [],
                total: 0,
            }
        },
        computed: {},
        methods: {
            async find_menu() {
                await axios.get(this.base_url + 'TestController/showFrontendMenu/' + this.frontendmenuid)
                    .then((response) => {
                        //console.log(response.data);
                        if (response.data.result) {
                            this.menu = response.data.result;
                            //console.log(sum);
                        } else {
                            this.menu = [];
                        }
                        //console.log(response.data.result)

                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }
        },

        template:
            /*html*/
            `
        <span v-for="(row,key) in menu" :key="key">{{ row.menu_name }}</span>
    `,
    });

    const appmount = app.mount("#app");
</script>