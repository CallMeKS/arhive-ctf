package main


import (
        "fmt"


)



func main() {

    line1 := "Caraval"
    check := [6]string{"Caraval","The Book of Shells","Legendary","Beasts of Prey", "Finale","The Queen of Nothing"}
    confirm :=0
    for _, book_check:= range check {
        if book_check == line1 {
            confirm +=1
        }
    }
    if confirm == 0 {
    fmt.Println("test")
    } else {
    fmt.Println("yessy")
    }


}


