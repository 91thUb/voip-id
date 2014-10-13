<?php

class DomainController extends \BaseController {

    /**
     * Instantiate a new DomainController instance.
     */
    public function __construct() {

        $this->beforeFilter('auth');
//        $this->beforeFilter('auth.admin');

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $domains = Domain::all();

        echo Config::get('settings.token');

        return View::make('domain.index')->with('domains', $domains);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        return View::make('domain.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
        $input = Input::only('domain', 'description');
        $input['prefix'] = rand(1,9).rand(1,9).rand(1,9);

        $rules = array(
            'domain' => 'required|unique:domains,domain',
            'prefix' => 'unique:domains,prefix',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => 'domain/create', 'errors' => $v, 'input' => TRUE));
        }

        $domain = new Domain([
            'id' => md5($input['domain'].time()),
            'user_id' => Auth::user()->id,
            'domain' => $input['domain'],
            'prefix' => $input['prefix'],
            'description' => $input['description'],
        ]);
        $domain->save();

//        $user = new User(array(
//            'email' => $input['email'],
//            'username' => $input['username'],
//            'password' => Hash::make($input['password']),
//            'status' => $input['status'],
//        ));
//        $user->profile()->associate($profile);
//        $user->save();

        if ($domain->id) {
            return Output::push(array(
                'path' => 'domain',
                'messages' => array('success' => _('You have created domain successfully')),
            ));
        } else {
            return Output::push(array(
                'path' => 'domain/create',
                'messages' => array('fail' => _('Fail to create domain')),
                'input' => TRUE,
            ));
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}