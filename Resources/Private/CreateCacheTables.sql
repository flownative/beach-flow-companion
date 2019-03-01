BEGIN;

CREATE TABLE IF NOT EXISTS "cache" (
  "identifier" VARCHAR(250) NOT NULL,
  "cache" VARCHAR(250) NOT NULL,
  "context" VARCHAR(150) NOT NULL,
  "created" INTEGER UNSIGNED DEFAULT '0' NOT NULL,
  "lifetime" INTEGER UNSIGNED DEFAULT '0' NOT NULL,
  "content" LONGTEXT NOT NULL,
  PRIMARY KEY ("identifier", "cache", "context")
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS "tags" (
  "identifier" VARCHAR(255) NOT NULL,
  "cache" VARCHAR(250) NOT NULL,
  "context" VARCHAR(150) NOT NULL,
  "tag" VARCHAR(255) NOT NULL,
  INDEX "identifier" ("identifier", "cache", "context"),
  INDEX "tag" ("tag")
) ENGINE = InnoDB;

COMMIT;
