import "../css/app.scss";
import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls";

// THREE.jsを用いた3D表現
window.addEventListener("DOMContentLoaded", () => {
  const canvas_element = document.querySelector(".header__canvas");
  // レンダラーを作成
  const renderer = new THREE.WebGLRenderer({
    canvas: canvas_element,
  });
  // シーンを作成
  const scene = new THREE.Scene();
  // カメラを作成
  const camera = new THREE.PerspectiveCamera(
    90,
    window.innerWidth / window.innerHeight,
    1,
    5000
  );
  camera.position.set(0, 0, 1000);
  // カメラコントローラーを作成
  const controls = new OrbitControls(camera, canvas_element);
  // 滑らかにカメラコントローラーを制御
  controls.enableDamping = true;
  controls.dampingFactor = 0.2;
  controls.enableZoom = false;
  controls.enablePan = false;
  // 平行光源を作成
  const directionalLight = new THREE.DirectionalLight(0xffffff);
  directionalLight.position.set(-1, -0.5, -0.4);
  scene.add(directionalLight);
  // 星屑を作成 (カメラの動きをわかりやすくする)
  const createStarField = () => {
    // 頂点情報を格納する配列
    const vertices = [];
    // 配置する範囲
    const range = 2400;
    // 配置する個数
    const length = 180;
    for (let i = 0; i < length; i++) {
      const x = range * (Math.random() - 0.5);
      const y = range * (Math.random() - 0.5);
      const z = range * (Math.random() - 0.5);
      vertices.push(x, y, z);
    }
    // 形状(ジオメトリ)データを作成
    const geometry = new THREE.BufferGeometry();
    geometry.setAttribute(
      "position",
      new THREE.Float32BufferAttribute(vertices, 3)
    );
    //テクスチャ準備
    const loader = new THREE.TextureLoader();
    // footer.phpの定数から参照する方法↓
    // const texture = loader.load(particle_img_path);
    const texture = loader.load(
      "/wp-content/themes/cosmos/public/images/particle.png"
    );
    // 素材,表面(マテリアル)を作成
    const material = new THREE.PointsMaterial({
      color: 0xffffff,
      size: 15, //サイズ
      opacity: 0.7, //透過性の数値
      map: texture,
      alphaMap: texture,
      transparent: true,
      // depthTest: false,
      // blending: THREE.AdditiveBlending,
    });
    // 物体(メッシュ)を作成
    const particle = new THREE.Points(geometry, material);
    // シーンに追加
    scene.add(particle);
    // 毎フレーム時に実行されるループイベント
    const tick = () => {
      particle.rotation.y += 0.003;
      // カメラコントローラーを更新
      controls.update();
      // レンダリング
      renderer.render(scene, camera);
      requestAnimationFrame(tick);
    };
    tick();
  };
  createStarField();
  // リサイズイベント発生時に実行
  const onResize = () => {
    // サイズを取得
    const width = window.innerWidth;
    const height = window.innerHeight;
    // レンダラーのサイズを調整
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(width, height);
    // カメラのアスペクト比を正す
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
  };
  window.addEventListener("resize", onResize);
  onResize();
});

// インターセプションオブザーバーを扱いやすくしたクラス
class ScrollObserver {
  // コンストラクター関数はクラスが初期化（インスタンス化）される時に呼ばれる関数
  // classのthisは生成されたインスタンスを指す
  constructor(elements, callback, options) {
    this.elements = document.querySelectorAll(elements);
    this.options = Object.assign(
      {
        root: null,
        // bottomを-300pxとするとビューポート下部が-300px程要素が入ったところで関数が発火する
        rootMargin: "0px 0px 0px 0px",
        // 要素のどの部分で関数が発火するのか指定できる（画面進入側の辺が0となる）
        threshold: 0,
        once: true,
      },
      options
    );
    this.callback = callback;
    this.once = this.options.once;
    this._init();
  }
  // ES6からは
  // _init: function () {} を
  // _init() {}と省略できるようになった。
  _init() {
    // entriesは監視対象のDOM群です(this.els.forEach(el => this.io.observe(el));)
    // observerはIntersectionObserverのインスタンスを意味しています
    this.storage_callback = (entries, observer) => {
      // entriesは監視される要素群の配列
      entries.forEach((entry) => {
        // entry.isIntersectingは監視要素が入ったときにtrue、出た時にfalse
        if (entry.isIntersecting) {
          this.callback(entry.target, true);
          if (this.once) {
            // 要素が入った段階で監視をやめたい時は以下を記述する(entry.targetは監視登録したDOM)
            observer.unobserve(entry.target);
          }
        } else {
          // コールバックをもう一度呼び出すためentry.isIntersectingがfalseの時にaddEventListenerや関数を消す処理を記述したい場合にはこのクラスを使うのはNG
          this.callback(entry.target, false);
        }
      });
    };
    // IntersectionObserverはwindowオブジェクトのプロパティなのでコールバック関数内でthisを使用している場合bindで意図するオブジェクトを指定しないとならない
    // もしくは無名関数で囲む
    this.intersection_observer = new IntersectionObserver(
      this.storage_callback.bind(this),
      this.options
    );
    // 以下で監視対象を登録するとコールバックが動き出す
    this.elements.forEach((el) => this.intersection_observer.observe(el));
  }
}

// トップへスクロール
window.addEventListener("DOMContentLoaded", () => {
  const access_element = document.querySelector(".access");
  if (access_element !== null) {
    const top_page_btn = document.querySelector(".access__arrow-btn");
    document.addEventListener("scroll", () => {
      const top_element = document.querySelector(".top");
      const top_element_bottom = top_element.getBoundingClientRect().bottom;
      if (top_element_bottom < -5000) {
        top_page_btn.classList.add("access__btn-active");
      } else {
        top_page_btn.classList.remove("access__btn-active");
      }
    });
    top_page_btn.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }
});

// ハンバーガーメニュー
document.addEventListener("DOMContentLoaded", () => {
  const hamburger_element = document.querySelector(".header__hamburger");
  hamburger_element.addEventListener("click", function () {
    // アロー関数と fucntion は、関数内の this が何を指すか異なります（アロー関数は宣言時に this が固定される）。完全互換ではないので気をつけましょう。
    this.classList.toggle("header__hamburger-active");
    document
      .querySelector(".header__canvas")
      .classList.toggle("header__active");
    document.querySelector(".header__nav").classList.toggle("header__active");
  });
});

// トップ画面の切り替わり
document.addEventListener("DOMContentLoaded", () => {
  const top_background_element = document.querySelector(".top__background");
  if (top_background_element !== null) {
    const image_lists = ["top-bg1.jpg", "top-bg2.jpg", "top-bg3.jpg"];
    const imageChange = (number) => {
      return new Promise((resolve) => {
        setTimeout(() => {
          top_background_element.style.backgroundImage = `url(/wp-content/themes/cosmos/public/images/${image_lists[number]})`;
          let imageNumber = ++number;
          resolve(imageNumber);
        }, 6000);
      });
    };
    async function asynchronousChain() {
      let imageNumber = await imageChange(0);
      imageNumber = await imageChange(imageNumber);
      imageNumber = await imageChange(imageNumber);
    }
    asynchronousChain();
    setInterval(asynchronousChain, 18000);
  }
});

// 文字が1文字ずつ出現
document.addEventListener("DOMContentLoaded", () => {
  const title_element = document.querySelectorAll(".js-title-animation");
  title_element.forEach((element) => {
    // 文字を一文字ずつ配列に変換
    const appearChars = element.innerHTML.trim().split("");
    element.innerHTML = appearChars.reduce((accumulate, current) => {
      current = current.replace(/\s+/, "&nbsp;");
      return `${accumulate}<span class = "title-character">${current}</span>`;
    }, "");
  });
  const callback = function (element, isIntersecting) {
    if (isIntersecting) {
      element.classList.add("js-title-animation-active");
    }
  };
  const so = new ScrollObserver(".js-title-animation", callback, {
    rootMargin: `-${window.innerHeight / 5}px 0px`,
  });
});

// 要素が下から出現
document.addEventListener("DOMContentLoaded", () => {
  const callback = (element, isIntersecting) => {
    if (isIntersecting) {
      element.classList.add("js-float-animation-active");
    }
  };
  const so = new ScrollObserver(".js-float-animation", callback, {
    rootMargin: `-${window.innerHeight / 5}px 0px`,
  });
});

// 写真のパララックス
document.addEventListener("DOMContentLoaded", () => {
  function imageParallax() {
    const flame_element = this.target;
    const window_height = window.innerHeight;
    const scroll_amount = window.scrollY;
    const img_element = flame_element.firstElementChild;
    const img_position =
      flame_element.getBoundingClientRect().top + scroll_amount;
    let parallaxSpeed =
      (img_element.clientHeight - flame_element.clientHeight) /
      (window_height + flame_element.clientHeight);
    let translateY =
      (scroll_amount + window_height - img_position) * parallaxSpeed;
    img_element.style.transform = `translateY(${translateY}px)`;
  }
  const object_identify_array = new Map();
  const callback = (target_element, isIntersecting) => {
    const unique_string = target_element.dataset.index;
    if (isIntersecting) {
      const event_object = {
        target: target_element,
        handleEvent: imageParallax,
      };
      const objectInsert = () => {
        object_identify_array.set(unique_string, event_object);
      };
      objectInsert();
      window.addEventListener("scroll", event_object);
    } else {
      window.removeEventListener(
        "scroll",
        object_identify_array.get(unique_string)
      );
    }
  };
  const so = new ScrollObserver(".concept__img-flame", callback, {
    once: false,
  });
});

// 文字のパララックス
document.addEventListener("DOMContentLoaded", () => {
  function textParallax() {
    const target_element = this.target;
    const window_width = window.innerWidth;
    const window_height = window.innerHeight;
    const scroll_amount = window.scrollY;
    const sense_position =
      target_element.getBoundingClientRect().top + scroll_amount;
    let parallaxSpeed;
    if (window_width < 600) {
      parallaxSpeed = 0.41;
    } else if (600 <= window_width && window_width < 750) {
      parallaxSpeed = 0.155;
    } else if (750 <= window_width && window_width < 900) {
      parallaxSpeed = 0.17;
    } else if (900 <= window_width && window_width < 1050) {
      parallaxSpeed = 0.245;
    } else if (1050 <= window_width && window_width < 1200) {
      parallaxSpeed = 0.265;
    } else if (1200 <= window_width && window_width < 1350) {
      parallaxSpeed = 0.285;
    } else {
      parallaxSpeed = 0.305;
    }
    const translateY =
      (scroll_amount + window_height - sense_position) * parallaxSpeed;
    target_element.style.transform = `translateY(${translateY}px)`;
  }
  const object_identify_array = new Map();
  const callback = (target_element, isIntersecting) => {
    const unique_string = target_element.dataset.index;
    if (isIntersecting) {
      const event_object = {
        target: target_element,
        handleEvent: textParallax,
      };
      const objectInsert = () => {
        object_identify_array.set(unique_string, event_object);
      };
      objectInsert();
      window.addEventListener("scroll", event_object);
    } else {
      window.removeEventListener(
        "scroll",
        object_identify_array.get(unique_string)
      );
    }
  };
  const so = new ScrollObserver(".concept__senses", callback, { once: false });
});

// スライダースワイプイベント設定
document.addEventListener("DOMContentLoaded", () => {
  const work_element = document.querySelector(".work");
  if (work_element !== null) {
    let target = document.querySelector(".work__slider");
    let startX; // タッチ開始 x座標
    let startY; // タッチ開始 y座標
    let endX; // 終了時の 座標
    let endY; // 終了時 y座標
    // タッチ開始時： xy座標を取得
    target.addEventListener("touchstart", (e) => {
      e.preventDefault();
      startX = e.touches[0].pageX;
      startY = e.touches[0].pageY;
    });
    const slide = document.querySelector(".work__list");
    // ↓指定した要素の子要素配列
    const slide_items = slide.children;
    const indicator = document.querySelector(".work__indicator");
    // ↓指定した要素の子要素配列
    const indicator_items = indicator.children;
    // 各配列のインデックス番号を定義
    const first_slide_index = 0;
    const last_slide_index = slide_items.length - 1;
    const first_indicator_index = 0;
    const last_indicator_index = indicator.length - 1;
    // タッチ終了時： スワイプした距離から左右どちらにスワイプしたかを判定する&距離が短い場合何もしない
    target.addEventListener("touchend", (e) => {
      const first_item = slide_items.item(first_slide_index);
      const last_item = slide_items.item(last_slide_index);
      const first_indicator = indicator_items.item(first_indicator_index);
      const last_indicator = indicator_items.item(last_indicator_index);
      endX = e.changedTouches[0].pageX;
      endY = e.changedTouches[0].pageY;
      if (startX - 30 > endX) {
        setTimeout(() => {
          // 現在のノードの次の兄弟ノードを表す Node、または存在しない場合は null です。(nextSibling)
          slide.insertBefore(first_item, last_item.nextSibling);
          indicator.insertBefore(last_indicator, first_indicator);
        }, 400);
      } else if (startX + 30 < endX) {
        setTimeout(() => {
          slide.insertBefore(last_item, first_item);
          indicator.insertBefore(first_indicator, last_indicator.nextSibling);
        }, 400);
      } else if (startY - endY < 10 && startY - endY > -10) {
        const current_slide_item = slide_items[2].children;
        const current_item_href = current_slide_item[0].href;
        window.location.href = current_item_href;
      }
    });
  }
});

// スライダーイベント
document.addEventListener("DOMContentLoaded", () => {
  const work_element = document.querySelector(".work");
  if (work_element !== null) {
    // IE11以外のブラウザだとNodeListはそのままforEachが使えます。(querySelectorAll)
    // 対して、HTMLCollectionはそのままだとforEachが使えません。(getElementsByClassName)
    const buttons = document.querySelectorAll(".work__btn");
    const prev_btn = document.querySelector(".work__btn-prev");
    const next_btn = document.querySelector(".work__btn-next");
    const slide = document.querySelector(".work__list");
    // childrenは指定した要素の子要素を取得する。childNodesはテキストノードと子要素を取得する。
    // ↓指定した要素の子要素配列
    const slide_items = slide.children;
    const indicator = document.querySelector(".work__indicator");
    // ↓指定した要素の子要素配列
    const indicator_items = indicator.children;
    // 各配列のインデックス番号を定義
    const first_slide_index = 0;
    const last_slide_index = slide_items.length - 1;
    const first_indicator_index = 0;
    const last_indicator_index = indicator_items.length - 1;
    buttons.forEach((button) => {
      button.addEventListener("click", () => {
        // item(引数) 引数の数字に当たる要素をノードリストから取得する
        const first_item = slide_items.item(first_slide_index);
        const last_item = slide_items.item(last_slide_index);
        const first_indicator = indicator_items.item(first_indicator_index);
        const last_indicator = indicator_items.item(last_indicator_index);
        if (button === prev_btn) {
          // insertBeforeは指定した要素を現在の要素の子要素として対象要素の前に挿入します。
          // let insertedElement = parentElement.insertBefore(newElement, referenceElement)
          // parentElement : 挿入したい位置の親要素   newElement : 挿入したい要素   referenceElement : この要素の前に newElement が挿入される
          // 現在のノードの次の兄弟ノードを表す Node、または存在しない場合は null です。(nextSibling)
          setTimeout(() => {
            slide.insertBefore(last_item, first_item);
            indicator.insertBefore(first_indicator, last_indicator.nextSibling);
          }, 400);
        } else if (button === next_btn) {
          setTimeout(() => {
            slide.insertBefore(first_item, last_item.nextSibling);
            indicator.insertBefore(last_indicator, first_indicator);
          }, 400);
        }
      });
    });
  }
});
