<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Tdd\Task;

use PlanB\Wand\Core\Task\Task;

class CodeceptTask extends Task
{

    /**
     * @inheritdoc
     */
    public function execute(): void
    {
        $codeception = $this->file('codeception');
        
        if ($codeception->exists()) {
            $this->logger->skip('[Tdd] Codeception is already installed in this directory');
        } else {
            $this->run('codecept_bootstrap');
            $this->run('codeception');
        }


        $this->run('unit_bootstrap');
        $this->run('acceptance_bootstrap');
        $this->run('functional_bootstrap');
    }
}
