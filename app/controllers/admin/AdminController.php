<?php namespace App\Controllers\Admin;

use Auth, BaseController, Form, Input, Redirect, Sentry, View, Request,Slider,Rounting,Photo,File,Response,Model,Sets,Validator,Str,Imagen,Fecha,Torneo,Evento,DB,Noticia,Seccion,Image,Configuracion;

class AdminController extends BaseController {

	/**
	 * Display the login page
	 * @return View
	 */

	public function __construct()
	{
		
	}

	public function index()
	{		
		return View::make('admin.home');
	}

}