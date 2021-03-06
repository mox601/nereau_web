PGDMP
     6                
    l            nereau_backup    8.2.9    8.2.9 =    �           0    0    ENCODING    ENCODING    SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS )   SET standard_conforming_strings = 'off';
                       false            �           1262    595634    nereau_backup    DATABASE K   CREATE DATABASE nereau_backup WITH TEMPLATE = template0 ENCODING = 'UTF8';
    DROP DATABASE nereau_backup;
             postgres    false                        2615    2200    public    SCHEMA    CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            �           0    0    SCHEMA public    COMMENT 6   COMMENT ON SCHEMA public IS 'Standard public schema';
                  postgres    false    5            �           0    0    public    ACL �   REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
                  postgres    false    5                       1259    595635    classes    TABLE �   CREATE TABLE classes (
    id integer NOT NULL,
    idterm integer NOT NULL,
    idtag integer NOT NULL,
    iduser integer NOT NULL,
    value real NOT NULL
);
    DROP TABLE public.classes;
       public         postgres    false    5            	           1259    595637    classes_id_seq    SEQUENCE p   CREATE SEQUENCE classes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
 %   DROP SEQUENCE public.classes_id_seq;
       public       postgres    false    1288    5            �           0    0    classes_id_seq    SEQUENCE OWNED BY 3   ALTER SEQUENCE classes_id_seq OWNED BY classes.id;
            public       postgres    false    1289            
           1259    595639    cooccurrences    TABLE �   CREATE TABLE cooccurrences (
    id integer NOT NULL,
    idclass integer NOT NULL,
    idterm integer NOT NULL,
    value real NOT NULL
);
 !   DROP TABLE public.cooccurrences;
       public         postgres    false    5                       1259    595641    cooccurrences_id_seq    SEQUENCE v   CREATE SEQUENCE cooccurrences_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
 +   DROP SEQUENCE public.cooccurrences_id_seq;
       public       postgres    false    1290    5            �           0    0    cooccurrences_id_seq    SEQUENCE OWNED BY ?   ALTER SEQUENCE cooccurrences_id_seq OWNED BY cooccurrences.id;
            public       postgres    false    1291                       1259    595643    stemmedterms    TABLE V   CREATE TABLE stemmedterms (
    id integer NOT NULL,
    stemmedterm text NOT NULL
);
     DROP TABLE public.stemmedterms;
       public         postgres    false    5                       1259    595648    stemmedterms_id_seq    SEQUENCE d   CREATE SEQUENCE stemmedterms_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
 *   DROP SEQUENCE public.stemmedterms_id_seq;
       public       postgres    false    1292    5            �           0    0    stemmedterms_id_seq    SEQUENCE OWNED BY =   ALTER SEQUENCE stemmedterms_id_seq OWNED BY stemmedterms.id;
            public       postgres    false    1293                       1259    595650    tags    TABLE F   CREATE TABLE tags (
    id integer NOT NULL,
    tag text NOT NULL
);
    DROP TABLE public.tags;
       public         postgres    false    5                       1259    595655    tags_id_seq    SEQUENCE \   CREATE SEQUENCE tags_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
 "   DROP SEQUENCE public.tags_id_seq;
       public       postgres    false    5    1294            �           0    0    tags_id_seq    SEQUENCE OWNED BY -   ALTER SEQUENCE tags_id_seq OWNED BY tags.id;
            public       postgres    false    1295                       1259    595657    terms    TABLE �   CREATE TABLE terms (
    id integer NOT NULL,
    idstemmedterm integer NOT NULL,
    term text NOT NULL,
    relevance integer DEFAULT 0
);
    DROP TABLE public.terms;
       public         postgres    false    1638    5                       1259    595663    terms_id_seq    SEQUENCE ]   CREATE SEQUENCE terms_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
 #   DROP SEQUENCE public.terms_id_seq;
       public       postgres    false    1296    5            �           0    0    terms_id_seq    SEQUENCE OWNED BY /   ALTER SEQUENCE terms_id_seq OWNED BY terms.id;
            public       postgres    false    1297                       1259    595672    users    TABLE �   CREATE TABLE users (
    id integer NOT NULL,
    username text NOT NULL,
    "password" text NOT NULL,
    lastupdate bigint
);
    DROP TABLE public.users;
       public         postgres    false    5                       1259    595677    users_id_seq    SEQUENCE ]   CREATE SEQUENCE users_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public       postgres    false    5    1298            �           0    0    users_id_seq    SEQUENCE OWNED BY /   ALTER SEQUENCE users_id_seq OWNED BY users.id;
            public       postgres    false    1299                       1259    595764    visitedurls    TABLE �   CREATE TABLE visitedurls (
    id integer NOT NULL,
    iduser integer NOT NULL,
    url text NOT NULL,
    query text NOT NULL,
    expandedquery text,
    date bigint NOT NULL
);
    DROP TABLE public.visitedurls;
       public         postgres    false    5                       1259    595762    visitedurls_id_seq    SEQUENCE c   CREATE SEQUENCE visitedurls_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
 )   DROP SEQUENCE public.visitedurls_id_seq;
       public       postgres    false    5    1301            �           0    0    visitedurls_id_seq    SEQUENCE OWNED BY ;   ALTER SEQUENCE visitedurls_id_seq OWNED BY visitedurls.id;
            public       postgres    false    1300                       1259    595791    visitedurltags    TABLE �   CREATE TABLE visitedurltags (
    id integer NOT NULL,
    idvisitedurl integer NOT NULL,
    idtag integer NOT NULL,
    value real NOT NULL
);
 "   DROP TABLE public.visitedurltags;
       public         postgres    false    5                       1259    595789    visitedurltags_id_seq    SEQUENCE f   CREATE SEQUENCE visitedurltags_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.visitedurltags_id_seq;
       public       postgres    false    5    1303            �           0    0    visitedurltags_id_seq    SEQUENCE OWNED BY A   ALTER SEQUENCE visitedurltags_id_seq OWNED BY visitedurltags.id;
            public       postgres    false    1302            b           2604    595686    id    DEFAULT U   ALTER TABLE classes ALTER COLUMN id SET DEFAULT nextval('classes_id_seq'::regclass);
 9   ALTER TABLE public.classes ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    1289    1288            c           2604    595687    id    DEFAULT a   ALTER TABLE cooccurrences ALTER COLUMN id SET DEFAULT nextval('cooccurrences_id_seq'::regclass);
 ?   ALTER TABLE public.cooccurrences ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    1291    1290            d           2604    595688    id    DEFAULT _   ALTER TABLE stemmedterms ALTER COLUMN id SET DEFAULT nextval('stemmedterms_id_seq'::regclass);
 >   ALTER TABLE public.stemmedterms ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    1293    1292            e           2604    595689    id    DEFAULT O   ALTER TABLE tags ALTER COLUMN id SET DEFAULT nextval('tags_id_seq'::regclass);
 6   ALTER TABLE public.tags ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    1295    1294            g           2604    595690    id    DEFAULT Q   ALTER TABLE terms ALTER COLUMN id SET DEFAULT nextval('terms_id_seq'::regclass);
 7   ALTER TABLE public.terms ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    1297    1296            h           2604    595692    id    DEFAULT Q   ALTER TABLE users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    1299    1298            i           2604    595766    id    DEFAULT ]   ALTER TABLE visitedurls ALTER COLUMN id SET DEFAULT nextval('visitedurls_id_seq'::regclass);
 =   ALTER TABLE public.visitedurls ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    1300    1301    1301            j           2604    595793    id    DEFAULT c   ALTER TABLE visitedurltags ALTER COLUMN id SET DEFAULT nextval('visitedurltags_id_seq'::regclass);
 @   ALTER TABLE public.visitedurltags ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    1302    1303    1303            l           2606    595695    classes_idterm_key 
   CONSTRAINT _   ALTER TABLE ONLY classes
    ADD CONSTRAINT classes_idterm_key UNIQUE (idterm, idtag, iduser);
 D   ALTER TABLE ONLY public.classes DROP CONSTRAINT classes_idterm_key;
       public         postgres    false    1288    1288    1288    1288            n           2606    595697    classes_pkey 
   CONSTRAINT K   ALTER TABLE ONLY classes
    ADD CONSTRAINT classes_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.classes DROP CONSTRAINT classes_pkey;
       public         postgres    false    1288    1288            p           2606    595699    cooccurrences_idclass_key 
   CONSTRAINT f   ALTER TABLE ONLY cooccurrences
    ADD CONSTRAINT cooccurrences_idclass_key UNIQUE (idclass, idterm);
 Q   ALTER TABLE ONLY public.cooccurrences DROP CONSTRAINT cooccurrences_idclass_key;
       public         postgres    false    1290    1290    1290            r           2606    595701    cooccurrences_pkey 
   CONSTRAINT W   ALTER TABLE ONLY cooccurrences
    ADD CONSTRAINT cooccurrences_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.cooccurrences DROP CONSTRAINT cooccurrences_pkey;
       public         postgres    false    1290    1290            t           2606    595703    stemmedterms_pkey 
   CONSTRAINT U   ALTER TABLE ONLY stemmedterms
    ADD CONSTRAINT stemmedterms_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.stemmedterms DROP CONSTRAINT stemmedterms_pkey;
       public         postgres    false    1292    1292            v           2606    595705    stemmedterms_stemmedterm_key 
   CONSTRAINT d   ALTER TABLE ONLY stemmedterms
    ADD CONSTRAINT stemmedterms_stemmedterm_key UNIQUE (stemmedterm);
 S   ALTER TABLE ONLY public.stemmedterms DROP CONSTRAINT stemmedterms_stemmedterm_key;
       public         postgres    false    1292    1292            x           2606    595707 	   tags_pkey 
   CONSTRAINT E   ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.tags DROP CONSTRAINT tags_pkey;
       public         postgres    false    1294    1294            z           2606    595709    tags_tag_key 
   CONSTRAINT D   ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_tag_key UNIQUE (tag);
 ;   ALTER TABLE ONLY public.tags DROP CONSTRAINT tags_tag_key;
       public         postgres    false    1294    1294            |           2606    595711    terms_idstemmedterm_key 
   CONSTRAINT `   ALTER TABLE ONLY terms
    ADD CONSTRAINT terms_idstemmedterm_key UNIQUE (idstemmedterm, term);
 G   ALTER TABLE ONLY public.terms DROP CONSTRAINT terms_idstemmedterm_key;
       public         postgres    false    1296    1296    1296            ~           2606    595713 
   terms_pkey 
   CONSTRAINT G   ALTER TABLE ONLY terms
    ADD CONSTRAINT terms_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.terms DROP CONSTRAINT terms_pkey;
       public         postgres    false    1296    1296            �           2606    595717 
   users_pkey 
   CONSTRAINT G   ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public         postgres    false    1298    1298            �           2606    595719    users_username_key 
   CONSTRAINT P   ALTER TABLE ONLY users
    ADD CONSTRAINT users_username_key UNIQUE (username);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_username_key;
       public         postgres    false    1298    1298            �           2606    595771    visitedurls_pkey 
   CONSTRAINT S   ALTER TABLE ONLY visitedurls
    ADD CONSTRAINT visitedurls_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.visitedurls DROP CONSTRAINT visitedurls_pkey;
       public         postgres    false    1301    1301            �           2606    595795    visitedurltags_pkey 
   CONSTRAINT Y   ALTER TABLE ONLY visitedurltags
    ADD CONSTRAINT visitedurltags_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.visitedurltags DROP CONSTRAINT visitedurltags_pkey;
       public         postgres    false    1303    1303            �           2606    595722    classes_idtag_fkey    FK CONSTRAINT h   ALTER TABLE ONLY classes
    ADD CONSTRAINT classes_idtag_fkey FOREIGN KEY (idtag) REFERENCES tags(id);
 D   ALTER TABLE ONLY public.classes DROP CONSTRAINT classes_idtag_fkey;
       public       postgres    false    1288    1655    1294            �           2606    595727    classes_idterm_fkey    FK CONSTRAINT r   ALTER TABLE ONLY classes
    ADD CONSTRAINT classes_idterm_fkey FOREIGN KEY (idterm) REFERENCES stemmedterms(id);
 E   ALTER TABLE ONLY public.classes DROP CONSTRAINT classes_idterm_fkey;
       public       postgres    false    1651    1292    1288            �           2606    595732    classes_iduser_fkey    FK CONSTRAINT k   ALTER TABLE ONLY classes
    ADD CONSTRAINT classes_iduser_fkey FOREIGN KEY (iduser) REFERENCES users(id);
 E   ALTER TABLE ONLY public.classes DROP CONSTRAINT classes_iduser_fkey;
       public       postgres    false    1288    1663    1298            �           2606    595737    cooccurrences_idclass_fkey    FK CONSTRAINT {   ALTER TABLE ONLY cooccurrences
    ADD CONSTRAINT cooccurrences_idclass_fkey FOREIGN KEY (idclass) REFERENCES classes(id);
 R   ALTER TABLE ONLY public.cooccurrences DROP CONSTRAINT cooccurrences_idclass_fkey;
       public       postgres    false    1645    1288    1290            �           2606    595742    cooccurrences_idterm_fkey    FK CONSTRAINT ~   ALTER TABLE ONLY cooccurrences
    ADD CONSTRAINT cooccurrences_idterm_fkey FOREIGN KEY (idterm) REFERENCES stemmedterms(id);
 Q   ALTER TABLE ONLY public.cooccurrences DROP CONSTRAINT cooccurrences_idterm_fkey;
       public       postgres    false    1651    1292    1290            �           2606    595747    terms_idstemmedterm_fkey    FK CONSTRAINT |   ALTER TABLE ONLY terms
    ADD CONSTRAINT terms_idstemmedterm_fkey FOREIGN KEY (idstemmedterm) REFERENCES stemmedterms(id);
 H   ALTER TABLE ONLY public.terms DROP CONSTRAINT terms_idstemmedterm_fkey;
       public       postgres    false    1651    1292    1296            �           2606    595772    visitedurls_iduser_fkey    FK CONSTRAINT s   ALTER TABLE ONLY visitedurls
    ADD CONSTRAINT visitedurls_iduser_fkey FOREIGN KEY (iduser) REFERENCES users(id);
 M   ALTER TABLE ONLY public.visitedurls DROP CONSTRAINT visitedurls_iduser_fkey;
       public       postgres    false    1301    1298    1663            �           2606    595801    visitedurltags_idtag_fkey    FK CONSTRAINT v   ALTER TABLE ONLY visitedurltags
    ADD CONSTRAINT visitedurltags_idtag_fkey FOREIGN KEY (idtag) REFERENCES tags(id);
 R   ALTER TABLE ONLY public.visitedurltags DROP CONSTRAINT visitedurltags_idtag_fkey;
       public       postgres    false    1294    1303    1655            �           2606    595796     visitedurltags_idvisitedurl_fkey    FK CONSTRAINT �   ALTER TABLE ONLY visitedurltags
    ADD CONSTRAINT visitedurltags_idvisitedurl_fkey FOREIGN KEY (idvisitedurl) REFERENCES visitedurls(id);
 Y   ALTER TABLE ONLY public.visitedurltags DROP CONSTRAINT visitedurltags_idvisitedurl_fkey;
       public       postgres    false    1667    1303    1301           