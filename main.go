package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"math/rand"
	"net/http"
	"strconv"
	"time"

	_ "github.com/go-sql-driver/mysql"
	"github.com/gorilla/mux"
)

type Album struct {
	Album_id   string `json:"album_id"`
	Album_name string `json:"album_name"`
	Artist_id  string `json:"artist_id"`
	Genre_id   string `json:"genre_id"`
}

type Artist struct {
	Artist_id   string `json:"artist_id"`
	Artist_name string `json:"artist_name"`
}

type Genre struct {
	Genre_id   string `json:"genre_id"`
	Genre_name string `json:"genre_name"`
}

type Playlist struct {
	Playlist_id   string `json:"playlist_id"`
	Playlist_name string `json:"playlist_name"`
	User_id       string `json:"user_id"`
}

type Song struct {
	Song_id   string `json:"song_id"`
	Date      string `json:"date"`
	Duration  string `json:"duration"`
	Song_name string `json:"song_name"`
	Path      string `json:"path"`
	Album_id  string `json:"album_id"`
}

type SongPlaylist struct {
	Song_id          string `json:"song_id"`
	Playlist_id      string `json:"playlist_id"`
	Song_playlist_id string `json:"song_playlist_id"`
}

type SongPlaylistHelp struct {
	Song_id     string `json:"song_id"`
	Playlist_id string `json:"playlist_id"`
}

type User struct {
	User_id  string `json:"user_id"`
	Username string `json:"username"`
	Password string `json:"password"`
}

type UserSignIn struct {
	Username string `json:"username"`
	Password string `json:"password"`
}

type UserPlaylist struct {
	Playlist_id      string `json:"playlist_id"`
	User_id          string `json:"user_id"`
	User_playlist_id string `json:"user_playlist_id"`
}

type FullSong struct {
	Song_id     string `json:"song_id"`
	Duration    string `json:"duration"`
	Song_name   string `json:"song_name"`
	Genre_name  string `json:"genre_name"`
	Artist_name string `json:"artist_name"`
	Album_name  string `json:"album_name"`
}

type FullPlaylist struct {
	Playlist_id   string     `json:"playlist_id"`
	Playlist_name string     `json:"playlist_name"`
	User_id       string     `json:"user_id"`
	Songs         []FullSong `json:"songs"`
}

type FullAlbum struct {
	Album_id    string     `json:"album_id"`
	Album_name  string     `json:"album_name"`
	Artist_name string     `json:"artist_name"`
	Genre_name  string     `json:"genre_name"`
	Songs       []FullSong `json:"songs"`
}

type PlaylistHelp struct {
	Playlist_name string `json:"playlist_name"`
}

func getUser(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var user User
	err1 := db.QueryRow("SELECT * FROM User WHERE User_id=?", params["id"]).Scan(&user.User_id, &user.Username, &user.Password)
	if err1 != nil {
		//log.Fatal(err1)
	}

	json.NewEncoder(w).Encode(&user)

	if err != nil {
		//log.Fatal(err)
	}
}

func getPlaylists(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var playlists []Playlist
	rows, err1 := db.Query("SELECT * FROM PlayList WHERE User_id=?", params["id"])
	if err1 != nil {
		//log.Fatal(err1)
	}

	i := 0
	for rows.Next() {
		playlists = append(playlists, Playlist{})
		rows.Scan(&playlists[i].Playlist_id, &playlists[i].Playlist_name, &playlists[i].User_id)
		i = i + 1
	}
	json.NewEncoder(w).Encode(&playlists)
}

func getPlaylist(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var playlist Playlist
	err1 := db.QueryRow("SELECT * FROM PlayList WHERE playlist_id=?", params["id"]).Scan(&playlist.Playlist_id, &playlist.Playlist_name, &playlist.User_id)
	if err1 != nil {
		//log.Fatal(err1)
	}

	json.NewEncoder(w).Encode(&playlist)

	if err != nil {
		//log.Fatal(err)
	}
}

func getPlaylistSongs(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var playlist Playlist
	err1 := db.QueryRow("SELECT * FROM PlayList WHERE playlist_id=?", params["id"]).Scan(&playlist.Playlist_id, &playlist.Playlist_name, &playlist.User_id)
	if err1 != nil {
		//log.Fatal(err1)
	}

	var songPlaylist []SongPlaylist
	rows, err2 := db.Query("SELECT * FROM Song_Playlist WHERE playlist_id=?", params["id"])

	if err2 != nil {
		//log.Fatal(err)
	}

	var songs []Song
	i := 0
	for rows.Next() {
		songPlaylist = append(songPlaylist, SongPlaylist{})
		songs = append(songs, Song{})
		rows.Scan(&songPlaylist[i].Song_id, &songPlaylist[i].Playlist_id, &songPlaylist[i].Song_playlist_id)
		err3 := db.QueryRow("SELECT * FROM Song WHERE song_id=?", songPlaylist[i].Song_id).Scan(&songs[i].Song_id, &songs[i].Date, &songs[i].Duration, &songs[i].Song_name, &songs[i].Path, &songs[i].Album_id)
		if err3 != nil {

		}
		i = i + 1
	}

	var fullSongs []FullSong
	for j := 0; j < len(songs); j++ {
		fullSongs = append(fullSongs, FullSong{})
		var album Album
		err3 := db.QueryRow("SELECT * FROM Album WHERE album_id=?", songs[j].Album_id).Scan(&album.Album_id, &album.Album_name, &album.Artist_id, &album.Genre_id)
		if err3 != nil {
			//log.Fatal(err)
		}
		var artist Artist
		err4 := db.QueryRow("SELECT * FROM Artist WHERE artist_id=?", album.Artist_id).Scan(&artist.Artist_id, &artist.Artist_name)
		if err4 != nil {
			//log.Fatal(err)
		}
		var genre Genre
		err5 := db.QueryRow("SELECT * FROM Genre WHERE genre_id=?", album.Genre_id).Scan(&genre.Genre_id, &genre.Genre_name)
		if err5 != nil {
			//log.Fatal(err)
		}
		fullSongs[j].Album_name = album.Album_name
		fullSongs[j].Artist_name = artist.Artist_name
		fullSongs[j].Duration = songs[j].Duration
		fullSongs[j].Genre_name = genre.Genre_name
		fullSongs[j].Song_id = songs[j].Song_id
		fullSongs[j].Song_name = songs[j].Song_name
	}

	fullPlaylist := FullPlaylist{}
	fullPlaylist.Playlist_id = playlist.Playlist_id
	fullPlaylist.Playlist_name = playlist.Playlist_name
	fullPlaylist.Songs = fullSongs
	fullPlaylist.User_id = playlist.User_id

	if err != nil {
		//log.Fatal(err)
	}

	json.NewEncoder(w).Encode(&fullPlaylist)
}

func getArtist(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var artist Artist
	err1 := db.QueryRow("SELECT * FROM Artist WHERE artist_id=?", params["id"]).Scan(&artist.Artist_id, &artist.Artist_name)
	if err1 != nil {
		//log.Fatal(err1)
	}

	json.NewEncoder(w).Encode(&artist)

	if err != nil {
		//log.Fatal(err)
	}
}

func getArtistAlbums(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	if err != nil {
		//log.Fatal(err)
	}

	var albums []Album
	rows, err1 := db.Query("SELECT * FROM Album WHERE artist_id=?", params["id"])
	if err1 != nil {
		//log.fatal(err1)
	}

	i := 0
	for rows.Next() {
		albums = append(albums, Album{})
		rows.Scan(&albums[i].Album_id, &albums[i].Album_name, &albums[i].Artist_id, &albums[i].Genre_id)
		i = i + 1
	}

	json.NewEncoder(w).Encode(&albums)
}

func getArtistSongs(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	if err != nil {
		//log.Fatal(err)
	}

	var albums []Album
	rows, err1 := db.Query("SELECT * FROM Album WHERE artist_id=?", params["id"])
	if err1 != nil {
		//log.fatal(err1)
	}

	var songs []Song
	i := 0
	for rows.Next() {
		albums = append(albums, Album{})
		rows.Scan(&albums[i].Album_id, &albums[i].Album_name, &albums[i].Artist_id, &albums[i].Genre_id)
		rows1, err2 := db.Query("SELECT * FROM Song WHERE album_id=?", albums[i].Album_id)
		if err2 != nil {

		}

		j := 0
		for rows1.Next() {
			songs = append(songs, Song{})
			rows1.Scan(&songs[j].Song_id, &songs[j].Date, &songs[j].Duration, &songs[j].Song_name, &songs[j].Path, &songs[j].Album_id)
			j = j + 1
		}
		i = i + 1
	}

	var fullSongs []FullSong
	for k := 0; k < len(songs); k++ {
		fullSongs = append(fullSongs, FullSong{})
		var album Album
		err3 := db.QueryRow("SELECT * FROM Album WHERE album_id=?", songs[k].Album_id).Scan(&album.Album_id, &album.Album_name, &album.Artist_id, &album.Genre_id)
		if err3 != nil {
			//log.Fatal(err)
		}
		var artist Artist
		err4 := db.QueryRow("SELECT * FROM Artist WHERE artist_id=?", album.Artist_id).Scan(&artist.Artist_id, &artist.Artist_name)
		if err4 != nil {
			//log.Fatal(err)
		}
		var genre Genre
		err5 := db.QueryRow("SELECT * FROM Genre WHERE genre_id=?", album.Genre_id).Scan(&genre.Genre_id, &genre.Genre_name)
		if err5 != nil {
			//log.Fatal(err)
		}
		fullSongs[k].Album_name = album.Album_name
		fullSongs[k].Artist_name = artist.Artist_name
		fullSongs[k].Duration = songs[k].Duration
		fullSongs[k].Genre_name = genre.Genre_name
		fullSongs[k].Song_id = songs[k].Song_id
		fullSongs[k].Song_name = songs[k].Song_name
	}

	json.NewEncoder(w).Encode(&fullSongs)

}

func getSong(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var song Song
	err1 := db.QueryRow("SELECT * FROM Song WHERE song_id=?", params["id"]).Scan(&song.Song_id, &song.Date, &song.Duration, &song.Song_name, &song.Path, &song.Album_id)
	if err1 != nil {
		//log.Fatal(err1)
	}

	var album Album
	err3 := db.QueryRow("SELECT * FROM Album WHERE album_id=?", song.Album_id).Scan(&album.Album_id, &album.Album_name, &album.Artist_id, &album.Genre_id)
	if err3 != nil {
		//log.Fatal(err)
	}
	var artist Artist
	err4 := db.QueryRow("SELECT * FROM Artist WHERE artist_id=?", album.Artist_id).Scan(&artist.Artist_id, &artist.Artist_name)
	if err4 != nil {
		//log.Fatal(err)
	}
	var genre Genre
	err5 := db.QueryRow("SELECT * FROM Genre WHERE genre_id=?", album.Genre_id).Scan(&genre.Genre_id, &genre.Genre_name)
	if err5 != nil {
		//log.Fatal(err)
	}

	fullSong := FullSong{}
	fullSong.Album_name = album.Album_name
	fullSong.Artist_name = artist.Artist_name
	fullSong.Duration = song.Duration
	fullSong.Genre_name = genre.Genre_name
	fullSong.Song_id = song.Song_id
	fullSong.Song_name = song.Song_name

	json.NewEncoder(w).Encode(&fullSong)

	if err != nil {
		//log.Fatal(err)
	}
}

func searchSongs(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var songs []Song
	str := "%" + params["search"] + "%"
	rows, err1 := db.Query("SELECT * FROM Song WHERE song_name LIKE ?", str)
	if err1 != nil {
		//log.Fatal(err1)
	}

	i := 0
	var fullSongs []FullSong
	for rows.Next() {
		songs = append(songs, Song{})
		fullSongs = append(fullSongs, FullSong{})
		rows.Scan(&songs[i].Song_id, &songs[i].Date, &songs[i].Duration, &songs[i].Song_name, &songs[i].Path, &songs[i].Album_id)
		var album Album
		err3 := db.QueryRow("SELECT * FROM Album WHERE album_id=?", songs[i].Album_id).Scan(&album.Album_id, &album.Album_name, &album.Artist_id, &album.Genre_id)
		if err3 != nil {
			//log.Fatal(err)
		}
		var artist Artist
		err4 := db.QueryRow("SELECT * FROM Artist WHERE artist_id=?", album.Artist_id).Scan(&artist.Artist_id, &artist.Artist_name)
		if err4 != nil {
			//log.Fatal(err)
		}
		var genre Genre
		err5 := db.QueryRow("SELECT * FROM Genre WHERE genre_id=?", album.Genre_id).Scan(&genre.Genre_id, &genre.Genre_name)
		if err5 != nil {
			//log.Fatal(err)
		}
		fullSongs[i].Album_name = album.Album_name
		fullSongs[i].Artist_name = artist.Artist_name
		fullSongs[i].Duration = songs[i].Duration
		fullSongs[i].Genre_name = genre.Genre_name
		fullSongs[i].Song_id = songs[i].Song_id
		fullSongs[i].Song_name = songs[i].Song_name
		i = i + 1
	}

	json.NewEncoder(w).Encode(&fullSongs)

}

func searchArtists(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var artists []Artist
	str := "%" + params["search"] + "%"
	rows, err1 := db.Query("SELECT * FROM Artist WHERE artist_name LIKE ?", str)
	if err1 != nil {
		//log.Fatal(err1)
	}

	i := 0
	for rows.Next() {
		artists = append(artists, Artist{})
		rows.Scan(&artists[i].Artist_id, &artists[i].Artist_name)
		i = i + 1
	}

	json.NewEncoder(w).Encode(&artists)
}

func searchPlaylists(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var playlists []Playlist
	str := "%" + params["search"] + "%"
	rows, err1 := db.Query("SELECT * FROM Playlist WHERE playlist_name LIKE ?", str)
	if err1 != nil {
		//log.Fatal(err1)
	}

	i := 0
	for rows.Next() {
		playlists = append(playlists, Playlist{})
		rows.Scan(&playlists[i].Playlist_id, &playlists[i].Playlist_name, &playlists[i].User_id)
		i = i + 1
	}

	json.NewEncoder(w).Encode(&playlists)
}

func searchAlbums(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var albums []Album
	str := "%" + params["search"] + "%"
	rows, err1 := db.Query("SELECT * FROM Album WHERE album_name LIKE ?", str)
	if err1 != nil {
		//log.Fatal(err1)
	}

	var fullAlbums []FullAlbum
	i := 0
	for rows.Next() {
		albums = append(albums, Album{})
		rows.Scan(&albums[i].Album_id, &albums[i].Album_name, &albums[i].Artist_id, &albums[i].Genre_id)
		var artist Artist
		err2 := db.QueryRow("SELECT * FROM Artist WHERE artist_id=?", albums[i].Artist_id).Scan(&artist.Artist_id, &artist.Artist_name)
		if err2 != nil {

		}
		var genre Genre
		err3 := db.QueryRow("SELECT * FROM Genre WHERE genre_id=?", albums[i].Genre_id).Scan(&genre.Genre_id, &genre.Genre_name)
		if err3 != nil {

		}
		fullAlbums = append(fullAlbums, FullAlbum{})
		fullAlbums[i].Album_id = albums[i].Album_id
		fullAlbums[i].Album_name = albums[i].Album_name
		fullAlbums[i].Artist_name = artist.Artist_name
		fullAlbums[i].Genre_name = genre.Genre_name
		i = i + 1
	}
	json.NewEncoder(w).Encode(&fullAlbums)
}

func getAlbum(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var album Album
	err1 := db.QueryRow("SELECT * FROM Album WHERE album_id=?", params["id"]).Scan(&album.Album_id, &album.Album_name, &album.Artist_id, &album.Genre_id)
	if err1 != nil {
		//log.Fatal(err1)
	}

	json.NewEncoder(w).Encode(&album)

	if err != nil {
		//log.Fatal(err)
	}
}

func getAlbumSongs(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)

	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	if err != nil {
		//log.Fatal(err)
	}

	var songs []Song
	rows, err1 := db.Query("SELECT * FROM Song WHERE album_id=?", params["id"])
	if err1 != nil {
		//log.fatal(err1)
	}

	i := 0
	for rows.Next() {
		songs = append(songs, Song{})
		rows.Scan(&songs[i].Song_id, &songs[i].Date, &songs[i].Duration, &songs[i].Song_name, &songs[i].Path, &songs[i].Album_id)
		i = i + 1
	}

	var fullSongs []FullSong
	for j := 0; j < len(songs); j++ {
		fullSongs = append(fullSongs, FullSong{})
		var album Album
		err3 := db.QueryRow("SELECT * FROM Album WHERE album_id=?", songs[j].Album_id).Scan(&album.Album_id, &album.Album_name, &album.Artist_id, &album.Genre_id)
		if err3 != nil {
			//log.Fatal(err)
		}
		var artist Artist
		err4 := db.QueryRow("SELECT * FROM Artist WHERE artist_id=?", album.Artist_id).Scan(&artist.Artist_id, &artist.Artist_name)
		if err4 != nil {
			//log.Fatal(err)
		}
		var genre Genre
		err5 := db.QueryRow("SELECT * FROM Genre WHERE genre_id=?", album.Genre_id).Scan(&genre.Genre_id, &genre.Genre_name)
		if err5 != nil {
			//log.Fatal(err)
		}
		fullSongs[j].Album_name = album.Album_name
		fullSongs[j].Artist_name = artist.Artist_name
		fullSongs[j].Duration = songs[j].Duration
		fullSongs[j].Genre_name = genre.Genre_name
		fullSongs[j].Song_id = songs[j].Song_id
		fullSongs[j].Song_name = songs[j].Song_name
	}

	fullAlbum := FullAlbum{}
	fullAlbum.Songs = fullSongs
	fullAlbum.Album_id = params["id"]
	fullAlbum.Album_name = fullSongs[0].Album_name
	fullAlbum.Artist_name = fullSongs[0].Artist_name
	fullAlbum.Genre_name = fullSongs[0].Genre_name

	json.NewEncoder(w).Encode(&fullAlbum)
}

func createUser(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")
	var user UserSignIn
	_ = json.NewDecoder(r.Body).Decode(&user)

	//insert query
	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	//seed := time.Now().UnixNano() / int64(time.Millisecond)
	id := strconv.Itoa(rand.Intn(100000))

	insert, err1 := db.Query("INSERT INTO User (user_id, username, password) VALUES (?, ?, ?)", id, user.Username, user.Password)
	if err1 != nil {
		//log.Fatal(err1)
	}
	defer insert.Close()

	var user1 User
	err2 := db.QueryRow("SELECT * FROM User WHERE Username=?", user.Username).Scan(&user1.User_id, &user1.Username, &user1.Password)
	if err2 != nil {
		//log.Fatal(err1)
	}

	json.NewEncoder(w).Encode(&user1)
}

func signIn(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")
	var user UserSignIn
	_ = json.NewDecoder(r.Body).Decode(&user)

	//insert query
	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	var user1 User
	err1 := db.QueryRow("SELECT * FROM User WHERE username=? AND password=?", user.Username, user.Password).Scan(&user1.User_id, &user1.Username, &user1.Password)
	if err1 != nil {
		//log.Fatal(err1)
	}

	json.NewEncoder(w).Encode(&user1)
}

func insertSong(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")
	var songPlaylist SongPlaylistHelp
	_ = json.NewDecoder(r.Body).Decode(&songPlaylist)

	//insert query
	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	//seed := time.Now().UnixNano() / int64(time.Millisecond)
	id := strconv.Itoa(rand.Intn(100000))

	insert, err1 := db.Query("INSERT INTO Song_Playlist (song_id, playlist_id, song_playlist_id) VALUES (?, ?, ?)", songPlaylist.Song_id, songPlaylist.Playlist_id, id)
	if err1 != nil {
		//log.Fatal(err1)
	}
	defer insert.Close()

	var songPlaylist1 SongPlaylist
	err2 := db.QueryRow("SELECT * FROM Song_Playlist WHERE song_id=? AND playlist_id=?", songPlaylist.Song_id, songPlaylist.Playlist_id).Scan(&songPlaylist1.Song_id, &songPlaylist1.Playlist_id, &songPlaylist1.Song_playlist_id)
	if err2 != nil {
		//log.Fatal(err1)
	}

	json.NewEncoder(w).Encode(&songPlaylist1)
} //put song in playlist

func createPlaylist(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)
	var playlist PlaylistHelp
	_ = json.NewDecoder(r.Body).Decode(&playlist)

	//insert query
	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	//seed := time.Now().UnixNano() / int64(time.Millisecond)
	id := strconv.Itoa(rand.Intn(100000))

	insert, err1 := db.Query("INSERT INTO Playlist (playlist_id, playlist_name, user_id) VALUES (?, ?, ?)", id, playlist.Playlist_name, params["id"])
	if err1 != nil {
		//log.Fatal(err1)
	}
	defer insert.Close()

	var playlist1 Playlist
	err2 := db.QueryRow("SELECT * FROM Playlist WHERE user_id=? AND playlist_name=?", params["id"], playlist.Playlist_name).Scan(&playlist1.Playlist_id, &playlist1.Playlist_name, &playlist1.User_id)
	if err2 != nil {
		//log.Fatal(err1)
	}

	json.NewEncoder(w).Encode(&playlist1)
}

func editName(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json") //serves response as json instead of text
	params := mux.Vars(r)                              //get params (id in this case)
	var playlist PlaylistHelp
	_ = json.NewDecoder(r.Body).Decode(&playlist)

	//insert query
	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:3306)/db_project") //mysql, Username:Password@tcp(localhostip:3306)/db
	if err != nil {
		//log.Fatal(err)
	}
	defer db.Close()
	fmt.Println("Connected to db")

	insert, err1 := db.Query("UPDATE Playlist SET playlist_name=? WHERE playlist_id=?", playlist.Playlist_name, params["id"])
	if err1 != nil {
		//log.Fatal(err1)
	}
	defer insert.Close()

	var playlist1 Playlist
	err2 := db.QueryRow("SELECT * FROM Playlist WHERE playlist_id=?", params["id"]).Scan(&playlist1.Playlist_id, &playlist1.Playlist_name, &playlist1.User_id)
	if err2 != nil {
		//log.Fatal(err2)
	}

	json.NewEncoder(w).Encode(&playlist1)
}

func main() {
	rand.Seed(time.Now().UTC().UnixNano())
	router := mux.NewRouter()
	//*******************GET METHODS*********************//
	router.HandleFunc("/api/users/{id}", getUser).Methods("GET")
	router.HandleFunc("/api/users/{id}/playlists", getPlaylists).Methods("GET")
	router.HandleFunc("/api/playlists/{id}", getPlaylist).Methods("GET")
	router.HandleFunc("/api/playlists/{id}/songs", getPlaylistSongs).Methods("GET")
	router.HandleFunc("/api/artists/{id}", getArtist).Methods("GET")
	router.HandleFunc("/api/artists/{id}/albums", getArtistAlbums).Methods("GET")
	router.HandleFunc("/api/artists/{id}/songs", getArtistSongs).Methods("GET")
	router.HandleFunc("/api/songs/{id}", getSong).Methods("GET")
	router.HandleFunc("/api/search/songs/{search}", searchSongs).Methods("GET")
	router.HandleFunc("/api/search/artists/{search}", searchArtists).Methods("GET")
	router.HandleFunc("/api/search/playlists/{search}", searchPlaylists).Methods("GET")
	router.HandleFunc("/api/search/albums/{search}", searchAlbums).Methods("GET")
	router.HandleFunc("/api/albums/{id}", getAlbum).Methods("GET")
	router.HandleFunc("/api/albums/{id}/songs", getAlbumSongs).Methods("GET")
	//*******************POST METHODS********************//
	router.HandleFunc("/api/users/signin", signIn).Methods("POST")
	router.HandleFunc("/api/users", createUser).Methods("POST")
	router.HandleFunc("/api/playlists", insertSong).Methods("POST")
	router.HandleFunc("/api/users/{id}/playlists", createPlaylist).Methods("POST")
	router.HandleFunc("/api/playlists/{id}", editName).Methods("POST")
	//*****************DELETE METHODS********************//
	//*******************PUT METHODS*********************//

	log.Fatal(http.ListenAndServe(":8000", router))
}
