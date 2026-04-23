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
        
        $table->addColumn('activated', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        
        $table->addColumn('activation_token', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);

        $table->addColumn('activation_expires', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}
