<?php

class Contact {
    protected $dbs;
    protected $table = 'massage';

    public function __construct()
    {
        $this->dbs = new Database();
    }

    public function create($formData) {

        $formData = Sanitizer::sanitize($formData);

        $csrf_token = $formData['csrf_token'];

        if(!CsrfToken::validate($csrf_token)) {
            Semej::set('danger','error','Missing csrftoken');
            header('location:contact.php');die;
        }

        $email = $formData['email'];
        $user = $this->dbs->select("users", "email = '$email'");

        if (count($user) != 1) {
            Semej::set('danger', 'error', "email not found");
            header('Location:contact.php');die; 
        }

        $data = [
            'name' => $formData['name'],
            'email' => $formData['email'],
            'phone' => $formData['phone'],
            'message' => $formData['message']
        ];
        
        $result = $this->dbs->insert($this->table, $data);

        if($result != 1) {
            Semej::set('danger', 'error', "message send filed");
            header('Location:contact.php');die;
        }

        Semej::set('success', 'OK', "message send successfully");
        header('Location:contact.php');die;
    }

    public function getAll() {
        $messages = $this->dbs->all($this->table);
        return $messages;
    }

    public function show($id) {
        $message = $this->dbs->select($this->table, "id = $id");
        $this->read($id);
        return $message[0];
    }

    public function read($id) {
        $data = [
            'is_read' => 1
        ];

        $this->dbs->update($this->table, $data, "id = $id");
    }

    public function delete($id) {
        $this->dbs->delete($this->table, "id = '$id'");
        Semej::set('warning', 'Warning', 'message deleted successfully.');
        header('Location: dashboard.php?page=messages');die;
    }
}