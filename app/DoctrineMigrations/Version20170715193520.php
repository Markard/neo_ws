<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170715193520 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $sql = <<<SQL
CREATE TABLE neo (
  id           BIGINT AUTO_INCREMENT PRIMARY KEY,
  reference_id BIGINT          NOT NULL,
  name         VARCHAR(255)    NOT NULL,
  speed        DECIMAL(21, 12) NOT NULL,
  date         DATE            NOT NULL,
  is_hazardous BOOL            NOT NULL
)
  ENGINE = InnoDb
  DEFAULT CHAR SET latin1
  DEFAULT COLLATE latin1_general_ci;
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE neo');
    }
}
