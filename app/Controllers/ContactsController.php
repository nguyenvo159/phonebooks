<?php

namespace App\Controllers;

use App\SessionGuard as Guard;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function __construct()
    {
        if (!Guard::isUserLoggedIn()) {
            redirect('/login');
        }

        parent::__construct();
    }

    public function index()
    {
        $this->sendPage('contacts/index', [
            'contacts' => Guard::user()->contacts
        ]);
    }
    public function create()
    {
        $this->sendPage('contacts/create', [
            'errors' => session_get_once('errors'),
            'old' => $this->getSavedFormValues()
        ]);
    }

    public function store()
    {
        $data = $this->filterContactData($_POST);
        $model_errors = Contact::validate($data);

        if (empty($model_errors)) {
            $contact = new Contact();
            $contact->fill($data);
            $contact->user()->associate(Guard::user());
            $contact->save();
            redirect('/');
        }

        // Lưu các giá trị của form vào $_SESSION['form']
        $this->saveFormValues($_POST);

        // Lưu các thông báo lỗi vào $_SESSION['errors']
        redirect('/contacts/add', ['errors' => $model_errors]);
    }

    protected function filterContactData(array $data)
    {
        return [
            'name' => $data['name'] ?? '',
            'phone' => preg_replace('/\D+/', '', $data['phone']),
            'notes' => $data['notes'] ?? ''
        ];
    }
}
