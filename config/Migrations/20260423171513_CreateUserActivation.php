<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUserActivation extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        
        $table = $this->table('users');

        $table->addColumn('is_active', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('email_token', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('email_token_expires', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        
        $table->update();
    }
}
