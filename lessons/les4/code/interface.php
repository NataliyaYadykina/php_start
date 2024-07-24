<?php

interface AbleToLunch
{
    public function goToLunch();
}

// interface AccessibleToRoom
// {
//     public function checkAccess();
// }

class Student implements AbleToLunch/*, AccessibleToRoom*/
{
    public function goToLunch()
    {
        return "I'm a student and I'm going to lunch at the cafeteria.\n";
    }

    // public function checkAccess()
    // {
    //     return "I'm a student and I have access to the room.\n";
    // }
}
