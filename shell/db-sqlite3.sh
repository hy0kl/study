#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x
db_name="statistics.db"
create_sql="create.sql"
cat > $create_sql << EOF
CREATE TABLE IF NOT EXISTS statistics(
    \`id\` INTEGER PRIMARY KEY,
    api_name TEXT NOT NULL,
    request_total INTEGER NOT NULL,
    max_tr INTEGER NOT NULL,
    avg_tr REAL NOT NULL,
    max_tt INTEGER NOT NULL,
    avg_tt REAL NOT NULL,
    is_200 INTEGER NOT NULL,
    rate_200 REAL NOT NULL,
    not_200 INTEGER NOT NULL,
    rate_n200 REAL NOT NULL,
    date_str TEXT NOT NULL
);
EOF

if [ ! -f "$db_name" ]
then
    > "$db_name"
    sqlite3 "$db_name" < $create_sql
fi
rm "$create_sql"

insert="insert.sql"
> $insert

i=0
while ((i < 10))
do
    rand_num=$(head -200 /dev/urandom | cksum | cut -f1 -d" ")
    cat >> $insert <<SQL
INSERT INTO statistics VALUES(NULL, 'test-api', $rand_num, 60000, 5.12, 45000, 3.12, 100, 98.12, 0, 0.0, '20141119');
SQL
    i=$((i + 1))
done

sqlite3 "$db_name" < "$insert"
rm "$insert"
