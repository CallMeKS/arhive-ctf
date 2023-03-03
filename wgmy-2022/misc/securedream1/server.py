#!/usr/bin/env python3

print('''\033[94m
♡ ☆ .♡‧₊˚ 
╭◜◝ ͡ ◜◝╮  ㅤ ╭◜◝ ͡ ◜◝╮. 
(             )  ♡   (             )☆ ♡
╰◟◞ ͜ ◟◞╭◜◝ ͡ ◜◝╮ ͜ ◟◞╯♡ 
. ☆  ㅤㅤ(                )☆ ♡
♡ 　      ╰◟◞ ͜ ◟◞╯ . ☆

	[Secure Dream v1.0]
\033[0m''')

payload = input("What is your dream in life?\n")
if any(filter(lambda c: c in 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"\'', payload)):
	print("\nA𝒘𝒘... W𝒆 𝒅𝒐𝒏'𝒕 𝒖𝒏𝒅𝒆𝒓𝒔𝒕𝒂𝒏𝒅 𝒚𝒐𝒖𝒓 𝒅𝒓𝒆𝒂𝒎 :(")
else:
	eval(payload)
