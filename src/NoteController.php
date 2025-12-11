<?php

declare(strict_types=1);

namespace App;

use App\Exception\NotFoundException;

require_once("AbstractController.php");

class NoteController extends AbstractController
{
    public function createAction(): void
    {
        if ($this->request->hasPost())
        {
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->database->createNote($noteData);
            header('Location: /?before=created');
            exit;
        }
        $this->view->render('create');
    }

    public function showAction(): void
    {
        $noteId = (int) $this->request->getParam('id');
        if (!$noteId)
        {
            header('Location: /?error=missingNoteId');
            exit;
        }
        
        try {        
            $note = $this->database->getNote( $noteId);
        } catch (NotFoundException $e) {
            header('Location: /?error=noteNotFound');
            exit;
        }
        $this->view->render('show', ['note' => $note]);
    }

        public function listAction(): void     
    {
        $this->view->render('list', [
            'notes' => $this->database->getNotes(),
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam('error'),
        ]);
    }
}