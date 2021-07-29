
from cs50 import SQL, get_float

db = SQL("sqlite:///information.db")

rows = db.execute("SELECT price_for_kiwi FROM data")

x = rows.get("price_for_kiwi")

