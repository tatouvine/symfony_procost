<?php

namespace App\Event;

use App\Entity\Src\Contact;

final class ContactCreated
{
    private Contact $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}
