<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
<!-- radio CSS -->
<link rel="stylesheet" href="assets/boxed-check.css">
<!-- Jquery 1.11.1 -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<!-- selectize css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.0/css/selectize.bootstrap5.css"/>
<!-- datatables css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/date-1.2.0/fc-4.2.1/fh-3.3.1/kt-2.8.0/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/sr-1.2.0/datatables.min.css"/>
<!--sweet alert css -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css" rel="stylesheet">
<!--fontawesome css -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css" rel="stylesheet">
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<!-- CSS for Buttons -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.3/css/buttons.dataTables.min.css">
<!-- CSS jquery ui -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>

  
.icondetail {
    position: absolute;
    right: 0;
    margin-bottom: -10px;
    bottom: 35;
}

 .form-control {
   border-radius: 20px;
 }

 .btn {
   border-radius: 25px;
 }



  /* membuat container atau wadah dari scrollbar dengan lebar 20px  */
  ::-webkit-scrollbar {
    width: 20px;
  }

  /* membuat background dari scrollbar */
  /* kasih warna transparan agar lebih estetik  */
  ::-webkit-scrollbar-track {
    background-color: transparent;
  }


  /* membuat styling pada batang atau bar scrollbar  */
  /* kita beri warna abu tua dengan lengkungan di sisi atas dan bawahnya  */
  ::-webkit-scrollbar-thumb {
    background-color: #d6dee1;
    border-radius: 20px;
    border: 6px solid transparent;
    background-clip: content-box;
  }

  /* warna akan berubah menjadi abu mudah saat kursor diarahkan  */
  ::-webkit-scrollbar-thumb:hover {
    background-color: #a8bbbf;
  }

  .searchstyle {
    border-bottom-right-radius: 20px;
    border-top-right-radius: 20px;
    width: 98%;
  }

  .toppercart {
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    font-size: 16px;
  }


@import url('https://fonts.googleapis.com/css?family=Roboto');

body{
	font-family: 'Roboto', sans-serif;
}
* {
	margin: 0;
	padding: 0;
}
i {
	margin-right: 10px;
}
/*----------bootstrap-navbar-css------------*/
.navbar-logo{
	padding: 15px;
	color: #fff;
}
.navbar-mainbg{
	background-color: #007bff;
	padding: 0px;
}
#navbarSupportedContent{
	overflow: hidden;
	position: relative;
}
#navbarSupportedContent ul{
	padding: 0px;
	margin: 0px;
}
#navbarSupportedContent ul li a i{
	margin-right: 10px;
}
#navbarSupportedContent li {
	list-style-type: none;
	float: left;
}
#navbarSupportedContent ul li a{
	color: rgba(255,255,255,0.5);
    text-decoration: none;
    font-size: 15px;
    display: block;
    padding: 20px 20px;
    transition-duration:0.6s;
	transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
    position: relative;
}
#navbarSupportedContent>ul>li.active>a{
	color: #007bff;
	background-color: transparent;
	transition: all 0.7s;
}
#navbarSupportedContent a:not(:only-child):after {
	content: "\f105";
	position: absolute;
	right: 20px;
	top: 10px;
	font-size: 14px;
	font-family: "Font Awesome 5 Free";
	display: inline-block;
	padding-right: 3px;
	vertical-align: middle;
	font-weight: 900;
	transition: 0.5s;
}
#navbarSupportedContent .active>a:not(:only-child):after {
	transform: rotate(90deg);
}
.hori-selector{
	display:inline-block;
	position:absolute;
	height: 100%;
	top: 0px;
	left: 0px;
	transition-duration:0.6s;
	transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
	background-color: #fff;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	margin-top: 10px;
}
.hori-selector .right,
.hori-selector .left{
	position: absolute;
	width: 25px;
	height: 25px;
	background-color: #fff;
	bottom: 10px;
}
.hori-selector .right{
	right: -25px;
}
.hori-selector .left{
	left: -25px;
}
.hori-selector .right:before,
.hori-selector .left:before{
	content: '';
    position: absolute;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #007bff;
}
.hori-selector .right:before{
	bottom: 0;
    right: -25px;
}
.hori-selector .left:before{
	bottom: 0;
    left: -25px;
}


@media(min-width: 992px){
	.navbar-expand-custom {
	    -ms-flex-flow: row nowrap;
	    flex-flow: row nowrap;
	    -ms-flex-pack: start;
	    justify-content: flex-start;
	}
	.navbar-expand-custom .navbar-nav {
	    -ms-flex-direction: row;
	    flex-direction: row;
	}
	.navbar-expand-custom .navbar-toggler {
	    display: none;
	}
	.navbar-expand-custom .navbar-collapse {
	    display: -ms-flexbox!important;
	    display: flex!important;
	    -ms-flex-preferred-size: auto;
	    flex-basis: auto;
	}
}


@media (max-width: 991px){
	#navbarSupportedContent ul li a{
		padding: 12px 30px;
	}
	.hori-selector{
		margin-top: 0px;
		margin-left: 10px;
		border-radius: 0;
		border-top-left-radius: 25px;
		border-bottom-left-radius: 25px;
	}
	.hori-selector .left,
	.hori-selector .right{
		right: 10px;
	}
	.hori-selector .left{
		top: -25px;
		left: auto;
	}
	.hori-selector .right{
		bottom: -25px;
	}
	.hori-selector .left:before{
		left: -25px;
		top: -25px;
	}
	.hori-selector .right:before{
		bottom: -25px;
		left: -25px;
	}
}



.img-container:hover img {
  filter: blur(3px);
}

.img-container .text-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  font-size: 1.5rem;
  text-align: center;
  opacity: 0;
  transition: all 0.5s;
}

.img-container:hover .text-overlay {
  opacity: 1;
  margin-top: -70px;
}



.form-control-noregex {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 20px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  }
  .form-control-noregex::-ms-expand {
    background-color: transparent;
    border: 0;
  }
  .form-control-noregex:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
  }
  .form-control-noregex::-webkit-input-placeholder {
    color: #6c757d;
    opacity: 1;
  }
  .form-control-noregex::-moz-placeholder {
    color: #6c757d;
    opacity: 1;
  }
  .form-control-noregex:-ms-input-placeholder {
    color: #6c757d;
    opacity: 1;
  }
  .form-control-noregex::-ms-input-placeholder {
    color: #6c757d;
    opacity: 1;
  }
  .form-control-noregex::placeholder {
    color: #6c757d;
    opacity: 1;
  }
  .form-control-noregex:disabled,
  .form-control-noregex[readonly] {
    background-color: #e9ecef;
    opacity: 1;
  }
  select.form-control-noregex:not([size]):not([multiple]) {
    height: calc(2.25rem + 2px);
  }
  select.form-control-noregex:focus::-ms-value {
    color: #495057;
    background-color: #fff;
  }
  .form-control-noregex-file,
  .form-control-noregex-range {
    display: block;
    width: 100%;
  }


  @font-face {
  font-family: 'Miguelito';
  src: url('font/Miguelito.otf') format('truetype');
 }

  .logocashier {
    position: absolute;
    margin-top: -60px;
    margin-left: 30px;
    font-family: Miguelito;
    font-size: 65px;
    color: #b3b3b3;
    font-weight: bold;
}

 .card-round,
 .alert-warning,
 .alert-danger,
 .alert-success,
 .alert-primary {
  border-radius: 20px;
}

.selectize-input {
  border-radius: 25px;
}



</style>


