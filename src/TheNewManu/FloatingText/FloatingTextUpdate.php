<?php

/* Copyright (C) 2019 TheNewManu All rights reserved.
 *
 * This document is the property of TheNewManu.
 * It is considered confidential and proprietary.
 *
 * This document may not be reproduced or transmitted in any form,
 * in whole or in part, without the express written permission of
 * TheNewManu.
 *
 * Contact: @TheNewManu on Telegram
 */

declare(strict_types=1);

namespace TheNewManu\FloatingText;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TF;
use pocketmine\level\particle\FloatingTextParticle;

class FloatingTextUpdate extends Task {

    /** @var Main */
    private $plugin;

    /**
     * @param Main $plugin
     */
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * @param int $currentTick
     * @return void
     */
    public function onRun(int $currentTick): void {
        foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $player) {
            foreach($this->getPlugin()->floatingTexts as $id => $ft) {
                $text = $this->getPlugin()->getFloatingTexts()->getNested("$id.text");
                $level = $this->getPlugin()->getServer()->getLevelByName($this->getPlugin()->getFloatingTexts()->getNested("$id.level"));
                if($player->hasPermission("ft.command.admin")) {
                    $ft->setText($this->getPlugin()->replaceProcess($player, $text) . TF::EOL . TF::YELLOW . "ID: " . $id);
                }else{
                    $ft->setText($this->getPlugin()->replaceProcess($player, $text));
                }
                $level->addParticle($ft, [$player]);
            }
        }
    }
    
    /**
     * @return Main
     */
    public function getPlugin(): Main {
        return $this->plugin;
    }
}
